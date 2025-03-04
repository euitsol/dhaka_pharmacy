<?php

namespace App\Jobs;

use App\Models\Medicine;
use App\Models\ProcessedImage;
use App\Services\BgRemoveService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Process\Exceptions\ProcessFailedException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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

    public function handle(): void
    {
        try {
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

            $processedImagePath = $this->processImage($originalPath);
            $metadata = $this->generateMetadata($originalPath, $backupPath, $processedImagePath);

            $this->markAsProcessed($metadata);
            $this->updateMedicineRecord($processedImagePath);

            Log::info("Successfully processed image for medicine ID: {$this->medicine->id}", [
                'original_path' => $originalPath,
                'new_path' => $originalPath,
                'backup_path' => $backupPath,
                'original_size' => $metadata['original']['size'],
                'processed_size' => $metadata['processed']['size']
            ]);

        } catch (Throwable $e) {
            $this->handleProcessingError($e);
            throw $e;
        }
    }

    private function validateProcessingNeeded(): void
    {
        if (!$this->force && $this->medicine->processedImage?->status === ProcessedImage::STATUS_PROCESSED) {
            Log::info("Skipping already processed medicine: {$this->medicine->id}");
            throw new \RuntimeException('Image already processed');
        }
    }

    private function markAsProcessing(): void
    {
        ProcessedImage::updateOrCreate(
            ['medicine_id' => $this->medicine->id],
            [
                'status' => ProcessedImage::STATUS_PROCESSING,
                'processed_at' => null,
                'metadata' => ['stage' => 'processing_started']
            ]
        );
    }

    private function validateImageExists(string $path): void
    {
        if (!Storage::disk(self::DISK_NAME)->exists($path)) {
            Log::error("Original image not found", [
                'medicine_id' => $this->medicine->id,
                'path' => $path,
                'disk' => self::DISK_NAME
            ]);
            throw new \RuntimeException("Original image not found: {$path}");
        }
    }

    private function createBackup(string $originalPath): string
    {
        $backupPath = 'backups/' . Str::uuid() . '_' . basename($originalPath);

        Storage::disk(self::DISK_NAME)->copy(
            $originalPath,
            $backupPath
        );

        Log::info("Created backup at {$backupPath}", [
            'medicine_id' => $this->medicine->id,
            'original_size' => Storage::disk(self::DISK_NAME)->size($originalPath)
        ]);

        return $backupPath;
    }

    private function processImage(string $imagePath): string
    {
        if (!Storage::disk(self::DISK_NAME)->exists($imagePath)) {
            Log::error("Image not found for processing", [
                'medicine_id' => $this->medicine->id,
                'image_path' => $imagePath
            ]);
            throw new \RuntimeException("Image not found at path: {$imagePath}");
        }

        // Create temporary paths
        $originalFullPath = storage_path('app/public/' . $imagePath);
        $tempDir = storage_path('app/temp');
        $tempBgRemovedPath = $tempDir.'/'.uniqid('bg_removed_'.rand()).'.png';
        $processedImageDirPrefix = storage_path('app/public/');
        $processedImageDirPostfix = dirname($imagePath);
        $processedImageFilename = Str::slug($this->medicine->name).'.png';
        $processedImageFullPath = $processedImageDirPrefix.$processedImageDirPostfix.'/'.$processedImageFilename;

        // Ensure temp directory exists
        if (!file_exists($tempDir)) {
            Storage::disk('local')->makeDirectory('temp');
        }

        // Remove background using the BgRemoveService
        try {
            $bgRemover = new BgRemoveService();
            $bgRemover->removeBackground($originalFullPath, $processedImageFullPath);
            
            Log::info("Image processed successfully with background removal", [
                'medicine_id' => $this->medicine->id,
                'original_path' => $imagePath,
                'processed_path' => $processedImageDirPostfix.'/'.$processedImageFilename
            ]);
        }
        catch (ProcessFailedException $e) {
            Log::error("Background removal failed: ".$e->getMessage(), [
                'medicine_id' => $this->medicine->id,
                'image_path' => $imagePath
            ]);
            throw new \RuntimeException("Background removal failed: ".$e->getMessage());
        }

        // Cleanup temp files if needed
        if (file_exists($tempBgRemovedPath)) {
            @unlink($tempBgRemovedPath);
        }

        Log::info("Image processed successfully", [
            'medicine_id' => $this->medicine->id,
            'processed_path' => $processedImageDirPostfix.'/'.$processedImageFilename
        ]);

        return $processedImageDirPostfix.'/'.$processedImageFilename;
    }

    private function generateMetadata(string $originalPath, string $backupPath, string $processedImagePath): array
    {
        if (!Storage::disk(self::DISK_NAME)->exists($originalPath)) {
            Log::error("Original image not found during metadata generation", [
                'medicine_id' => $this->medicine->id,
                'original_path' => $originalPath
            ]);
            throw new \RuntimeException("Original image not found at path: {$originalPath}");
        }

        $originalFullPath = storage_path('app/public/' . $originalPath);
        $processedImageFullPath = storage_path('app/public/' . $processedImagePath);

        if (!file_exists($originalFullPath) || !file_exists($processedImageFullPath)) {
            Log::error("Processed image file not found", [
                'medicine_id' => $this->medicine->id,
                'absolute_path' => $originalFullPath,
                'processed_absolute_path' => $processedImageFullPath
            ]);
            throw new \RuntimeException("Original image file not found at: {$originalFullPath}");
        }

        $imageSize = getimagesize($originalFullPath);
        $processedImageFullPath = storage_path('app/public/' . $processedImagePath);
        if ($imageSize === false || $processedImageFullPath === false) {
            Log::error("Failed to get image dimensions", [
                'medicine_id' => $this->medicine->id,
                'absolute_path' => $originalFullPath,
                'processed_absolute_path' => $processedImageFullPath
            ]);
            throw new \RuntimeException("Failed to get image dimensions for: {$originalFullPath}");
        }

        [$originalWidth, $originalHeight] = $imageSize;
        [$processedWidth, $processedHeight] = getimagesize($processedImageFullPath);

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($originalFullPath);
        $processedMime = $finfo->file($processedImageFullPath);

        $originalSize = Storage::disk(self::DISK_NAME)->size($originalPath);
        $processedSize = Storage::disk(self::DISK_NAME)->size($processedImagePath);

        Log::info("Metadata generated", [
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
                'width' => $processedWidth,
                'height' => $processedHeight,
                'mime' => $processedMime,
                'path' => $processedImagePath
            ],
            'ai_tags' => $this->generateAIMetadata()
        ];
    }

    private function markAsProcessed(array $metadata): void
    {
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
    }

    private function updateMedicineRecord(string $newImagePath): void
    {
        $this->medicine->update([
            'is_processed' => true,
            'image' => $newImagePath
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
    }

    private function generateAIMetadata(): array
    {
        $aiTags = ['pharmaceutical', 'healthcare'];
        $aiDescription = "AI-generated description for {$this->medicine->name}";

        return [
            'tags' => $aiTags,
            'description' => $aiDescription
        ];
    }

    private function purifyImageUrl(string $url): string
    {
        if (Str::startsWith($url, ['http://', 'https://'])) {
            $path = parse_url($url, PHP_URL_PATH);
            $url = ltrim($path, '/');
        }
        $url = Str::replaceFirst('storage/', '', $url);

        return $url;
    }
}
