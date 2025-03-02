<?php

namespace App\Jobs;

use App\Models\Medicine;
use App\Models\ProcessedImage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Enums\ImageDriver;
use App\Services\ImageProcessorService;
use Illuminate\Support\Str;
use Throwable;

class ProcessImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const TARGET_SIZE = 800;
    private const DISK_NAME = 'public';

    public function __construct(
        private readonly Medicine $medicine,
        private readonly bool $force = false
    ) {
    }

    public function handle(ImageProcessorService $imageProcessor): void
    {
        // try {
            Log::info("Starting image processing for medicine ID: {$this->medicine->id}", [
                'medicine_name' => $this->medicine->name,
                'force_processing' => $this->force
            ]);

            $this->validateProcessingNeeded();
            $this->markAsProcessing();

            $originalPath = $this->medicine->getRawOriginal('image');
            $originalPath = $this->purifyImageUrl($originalPath);

            Log::info("Retrieved original image path", [
                'medicine_id' => $this->medicine->id,
                'original_path' => $originalPath
            ]);

            $this->validateImageExists($originalPath);

            $backupPath = $this->createBackup($originalPath);

            $this->processImage($imageProcessor, $originalPath);
            $metadata = $this->generateMetadata($originalPath, $backupPath);

            $this->markAsProcessed($metadata);
            $this->updateMedicineRecord();

            Log::info("Successfully processed image for medicine ID: {$this->medicine->id}", [
                'original_path' => $originalPath,
                'new_path' => $metadata['processed']['path'],
                'backup_path' => $backupPath,
                'original_size' => $metadata['original']['size'],
                'processed_size' => $metadata['processed']['size']
            ]);

        // } catch (Throwable $e) {
        //     $this->handleProcessingError($e);
        //     throw $e;
        // }
    }

    private function validateProcessingNeeded(): void
    {
        Log::info("Validating if processing is needed for medicine ID: {$this->medicine->id}", [
            'force' => $this->force,
            'current_status' => $this->medicine->processedImage?->status ?? 'not_processed'
        ]);

        if (!$this->force && $this->medicine->processedImage?->status === ProcessedImage::STATUS_PROCESSED) {
            Log::info("Skipping already processed medicine: {$this->medicine->id}");
            throw new \RuntimeException('Image already processed');
        }

        Log::info("Processing validation passed for medicine ID: {$this->medicine->id}");
    }

    private function markAsProcessing(): void
    {
        Log::info("Marking medicine as processing", [
            'medicine_id' => $this->medicine->id
        ]);

        ProcessedImage::updateOrCreate(
            ['medicine_id' => $this->medicine->id],
            [
                'status' => ProcessedImage::STATUS_PROCESSING,
                'processed_at' => null,
                'metadata' => ['stage' => 'processing_started']
            ]
        );

        Log::info("Medicine marked as processing", [
            'medicine_id' => $this->medicine->id
        ]);
    }

    private function validateImageExists(string $path): void
    {
        Log::info("Validating image exists", [
            'medicine_id' => $this->medicine->id,
            'path' => $path,
            'disk' => self::DISK_NAME
        ]);

        if (!Storage::disk(self::DISK_NAME)->exists($path)) {
            Log::error("Original image not found", [
                'medicine_id' => $this->medicine->id,
                'path' => $path,
                'disk' => self::DISK_NAME
            ]);
            throw new \RuntimeException("Original image not found: {$path}");
        }

        Log::info("Image exists validation passed", [
            'medicine_id' => $this->medicine->id,
            'path' => $path
        ]);
    }

    private function createBackup(string $originalPath): string
    {
        Log::info("Creating backup for original image", [
            'medicine_id' => $this->medicine->id,
            'original_path' => $originalPath
        ]);

        $backupPath = 'backups/' . Str::uuid() . '_' . basename($originalPath);

        Storage::disk(self::DISK_NAME)->copy(
            $originalPath,
            $backupPath
        );

        Log::info("Created backup for original image", [
            'medicine_id' => $this->medicine->id,
            'original_path' => $originalPath,
            'backup_path' => $backupPath,
            'original_size' => Storage::disk(self::DISK_NAME)->size($originalPath),
            'backup_size' => Storage::disk(self::DISK_NAME)->size($backupPath)
        ]);

        return $backupPath;
    }

    private function processImage(ImageProcessorService $processor, string $imagePath): void
    {
        Log::info("Starting image processing", [
            'medicine_id' => $this->medicine->id,
            'image_path' => $imagePath
        ]);

        // Check if the file exists in the storage disk
        if (!Storage::disk(self::DISK_NAME)->exists($imagePath)) {
            Log::error("Image not found for processing", [
                'medicine_id' => $this->medicine->id,
                'image_path' => $imagePath,
                'disk' => self::DISK_NAME
            ]);
            throw new \RuntimeException("Image not found at path: {$imagePath}");
        }

        // Get the absolute file path
        $fullPath = storage_path('app/public/' . $imagePath);
        Log::info("Resolved absolute file path", [
            'medicine_id' => $this->medicine->id,
            'relative_path' => $imagePath,
            'absolute_path' => $fullPath,
            'file_exists' => file_exists($fullPath)
        ]);

        // Generate a new filename with jpg extension
        $pathInfo = pathinfo($imagePath);
        $newFilename = $pathInfo['filename'] . '.jpg';
        $newPath = $pathInfo['dirname'] . '/' . $newFilename;
        $newFullPath = storage_path('app/public/' . $newPath);

        Log::info("Generated new path for processed image", [
            'medicine_id' => $this->medicine->id,
            'original_path' => $imagePath,
            'new_path' => $newPath,
            'new_full_path' => $newFullPath
        ]);

        Log::info("Starting image transformation", [
            'medicine_id' => $this->medicine->id,
            'driver' => 'Gd',
            'fit_method' => 'FillMax',
            'target_size' => self::TARGET_SIZE
        ]);

        $processor
            ->useImageDriver(ImageDriver::Gd)
            ->load($fullPath)
            ->fit(Fit::FillMax, self::TARGET_SIZE, self::TARGET_SIZE)
            ->optimize()
            ->save($newFullPath);

        Log::info("Image transformation completed", [
            'medicine_id' => $this->medicine->id,
            'new_full_path' => $newFullPath,
            'file_exists' => file_exists($newFullPath),
            'file_size' => file_exists($newFullPath) ? filesize($newFullPath) : 0
        ]);

        // If the new path is different from the original, update the medicine's image path
        if ($newPath !== $imagePath) {
            $this->medicine->image = $newPath;
            Log::info("Updated medicine image path", [
                'medicine_id' => $this->medicine->id,
                'old_path' => $imagePath,
                'new_path' => $newPath
            ]);
        } else {
            Log::info("Image path unchanged", [
                'medicine_id' => $this->medicine->id,
                'path' => $imagePath
            ]);
        }
    }

    private function generateMetadata(string $originalPath, string $backupPath): array
    {
        Log::info("Generating metadata", [
            'medicine_id' => $this->medicine->id,
            'original_path' => $originalPath,
            'backup_path' => $backupPath
        ]);

        // Check if the file exists in the storage disk
        if (!Storage::disk(self::DISK_NAME)->exists($originalPath)) {
            Log::error("Original image not found during metadata generation", [
                'medicine_id' => $this->medicine->id,
                'original_path' => $originalPath
            ]);
            throw new \RuntimeException("Original image not found at path: {$originalPath}");
        }

        // Get the path info
        $pathInfo = pathinfo($originalPath);
        $newFilename = $pathInfo['filename'] . '.jpg';
        $newPath = $pathInfo['dirname'] . '/' . $newFilename;

        Log::info("Calculated new path for metadata", [
            'medicine_id' => $this->medicine->id,
            'original_path' => $originalPath,
            'path_info' => $pathInfo,
            'new_filename' => $newFilename,
            'new_path' => $newPath
        ]);

        // Get the absolute file path
        $originalFullPath = storage_path('app/public/' . $newPath);
        Log::info("Resolved absolute path for processed image", [
            'medicine_id' => $this->medicine->id,
            'relative_path' => $newPath,
            'absolute_path' => $originalFullPath
        ]);

        // Get image dimensions using getimagesize
        if (!file_exists($originalFullPath)) {
            Log::error("Processed image file not found", [
                'medicine_id' => $this->medicine->id,
                'absolute_path' => $originalFullPath
            ]);
            throw new \RuntimeException("Original image file not found at: {$originalFullPath}");
        }

        $imageSize = getimagesize($originalFullPath);
        if ($imageSize === false) {
            Log::error("Failed to get image dimensions", [
                'medicine_id' => $this->medicine->id,
                'absolute_path' => $originalFullPath
            ]);
            throw new \RuntimeException("Failed to get image dimensions for: {$originalFullPath}");
        }

        [$originalWidth, $originalHeight] = $imageSize;
        Log::info("Retrieved image dimensions", [
            'medicine_id' => $this->medicine->id,
            'width' => $originalWidth,
            'height' => $originalHeight
        ]);

        // Get MIME type directly from the file
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($originalFullPath);
        Log::info("Retrieved MIME type", [
            'medicine_id' => $this->medicine->id,
            'mime_type' => $mime
        ]);

        $originalSize = Storage::disk(self::DISK_NAME)->size($originalPath);
        $processedSize = Storage::disk(self::DISK_NAME)->size($newPath);

        Log::info("Completed metadata generation", [
            'medicine_id' => $this->medicine->id,
            'original_size' => $originalSize,
            'processed_size' => $processedSize,
            'size_reduction_percentage' => $originalSize > 0 ? round((1 - ($processedSize / $originalSize)) * 100, 2) : 0
        ]);

        return [
            'original' => [
                'size' => $originalSize,
                'width' => $originalWidth,
                'height' => $originalHeight,
                'mime' => $mime,
                'path' => $originalPath,
                'backup_path' => $backupPath
            ],
            'processed' => [
                'size' => $processedSize,
                'width' => $originalWidth, // Update with processed dimensions if changed
                'height' => $originalHeight, // Update with processed dimensions if changed
                'mime' => 'image/jpeg',
                'path' => $newPath
            ],
            'ai_tags' => $this->generateAIMetadata()
        ];
    }

    private function markAsProcessed(array $metadata): void
    {
        Log::info("Marking image as processed", [
            'medicine_id' => $this->medicine->id,
            'new_path' => $metadata['processed']['path'],
            'backup_path' => $metadata['original']['backup_path']
        ]);

        ProcessedImage::updateOrCreate(
            ['medicine_id' => $this->medicine->id],
            [
                'new_path' => $metadata['processed']['path'],
                'backup_path' => $metadata['original']['backup_path'],
                'metadata' => $metadata,
                'status' => ProcessedImage::STATUS_PROCESSED,
                'processed_at' => now()
            ]
        );

        Log::info("Image marked as processed successfully", [
            'medicine_id' => $this->medicine->id
        ]);
    }

    private function updateMedicineRecord(): void
    {
        Log::info("Updating medicine record", [
            'medicine_id' => $this->medicine->id,
            'image_path' => $this->medicine->image
        ]);

        $this->medicine->update([
            'is_processed' => true,
            'image' => $this->medicine->image // This will use the updated image path if it was changed
        ]);

        Log::info("Medicine record updated successfully", [
            'medicine_id' => $this->medicine->id,
            'is_processed' => true,
            'image_path' => $this->medicine->image
        ]);
    }

    private function handleProcessingError(Throwable $e): void
    {
        Log::error("Image processing error occurred", [
            'medicine_id' => $this->medicine->id,
            'error_message' => $e->getMessage(),
            'error_code' => $e->getCode(),
            'error_file' => $e->getFile(),
            'error_line' => $e->getLine()
        ]);

        ProcessedImage::updateOrCreate(
            ['medicine_id' => $this->medicine->id],
            [
                'metadata' => [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ],
                'status' => ProcessedImage::STATUS_FAILED,
                'processed_at' => now()
            ]
        );

        $this->medicine->update(['is_processed' => false]);
        Log::error("Image processing failed for medicine ID: {$this->medicine->id}", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        Log::info("Medicine record updated to reflect processing failure", [
            'medicine_id' => $this->medicine->id,
            'is_processed' => false
        ]);
    }

    private function generateAIMetadata(): array
    {
        Log::info("Generating AI metadata", [
            'medicine_id' => $this->medicine->id,
            'medicine_name' => $this->medicine->name
        ]);

        // TODO: Implement actual AI metadata generation
        $aiTags = ['pharmaceutical', 'healthcare'];
        $aiDescription = "AI-generated description for {$this->medicine->name}";

        Log::info("AI metadata generated", [
            'medicine_id' => $this->medicine->id,
            'tags' => $aiTags,
            'description' => $aiDescription
        ]);

        return [
            'tags' => $aiTags,
            'description' => $aiDescription
        ];
    }

    private function purifyImageUrl(string $url): string
    {
        Log::info("Purifying image URL".$url);


        // Remove URL parts if present
        if (Str::startsWith($url, ['http://', 'https://'])) {
            $path = parse_url($url, PHP_URL_PATH);
            $url = ltrim($path, '/');
        }
        // Remove storage/ prefix if present
        $url = Str::replaceFirst('storage/', '', $url);

        Log::info("Purified image URL".$url);
        return $url;

    }
}
