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
        try {
            $this->validateProcessingNeeded();
            $this->markAsProcessing();

            $originalPath = $this->medicine->getRawOriginal('image');
            $this->validateImageExists($originalPath);

            $backupPath = $this->createBackup($originalPath);

            $this->processImage($imageProcessor, $originalPath);
            $metadata = $this->generateMetadata($originalPath, $backupPath);

            $this->markAsProcessed($metadata);
            $this->updateMedicineRecord();

            Log::info("Successfully processed image for medicine ID: {$this->medicine->id}");

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

        Log::info("Created backup for {$originalPath} at {$backupPath}");
        return $backupPath;
    }

    private function processImage(ImageProcessorService $processor, string $imagePath): void
    {
        $fullPath = Storage::disk(self::DISK_NAME)->path($imagePath);

        $processor
            ->useImageDriver(ImageDriver::Gd)
            ->load($fullPath)
            ->fit(Fit::FillMax, self::TARGET_SIZE, self::TARGET_SIZE)
            ->optimize()
            ->save();
    }

    private function generateMetadata(string $originalPath, string $backupPath): array
    {
        $originalFullPath = Storage::disk(self::DISK_NAME)->path($originalPath);
        [$originalWidth, $originalHeight] = getimagesize($originalFullPath);

        return [
            'original' => [
                'size' => Storage::disk(self::DISK_NAME)->size($originalPath),
                'width' => $originalWidth,
                'height' => $originalHeight,
                'mime' => Storage::disk(self::DISK_NAME)->mimeType($originalPath),
                'path' => $originalPath,
                'backup_path' => $backupPath
            ],
            'processed' => [
                'size' => Storage::disk(self::DISK_NAME)->size($originalPath),
                'width' => $originalWidth, // Update with processed dimensions if changed
                'height' => $originalHeight, // Update with processed dimensions if changed
                'mime' => Storage::disk(self::DISK_NAME)->mimeType($originalPath),
                'path' => $originalPath
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

    private function updateMedicineRecord(): void
    {
        $this->medicine->update([
            'is_processed' => true,
            'image' => $this->medicine->image // Only update if path changes
        ]);
    }

    private function handleProcessingError(Throwable $e): void
    {
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
        Log::error("Image processing failed for medicine ID: {$this->medicine->id}", ['error' => $e]);
    }

    private function generateAIMetadata(): array
    {
        // TODO: Implement actual AI metadata generation
        return [
            'tags' => ['pharmaceutical', 'healthcare'],
            'description' => "AI-generated description for {$this->medicine->name}"
        ];
    }
}
