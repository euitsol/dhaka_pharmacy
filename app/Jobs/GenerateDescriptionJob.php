<?php

namespace App\Jobs;

use App\Models\Medicine;
use App\Services\DescriptionGenerateService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class GenerateDescriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Medicine $medicine,
        private readonly bool $force = false
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info("Starting description generation for medicine ID: {$this->medicine->id}", [
                'medicine_name' => $this->medicine->name,
                'force_generation' => $this->force
            ]);

            $this->validateGenerationNeeded();

            $data = $this->prepareData();
            $generatedDescription = $this->generateDescription($data);
            $this->updateMedicineDescription($generatedDescription);

            Log::info("Successfully generated description for medicine ID: {$this->medicine->id}", [
                'medicine_name' => $this->medicine->name,
            ]);

        } catch (Throwable $e) {
            $this->handleGenerationError($e);
            throw $e;
        }
    }

    private function validateGenerationNeeded(): void
    {
        if (!$this->force && !empty($this->medicine->description)) {
            Log::info("Skipping description generation for medicine with existing description: {$this->medicine->id}");
            throw new \RuntimeException('Medicine already has a description');
        }
    }

    private function prepareData(): array
    {
        return [
            'name' => $this->medicine->name,
            'generic_name' => optional($this->medicine->generic)->name ?? 'Null',
            'company_name' => optional($this->medicine->company)->name ?? 'Null',
            'strength' => optional($this->medicine->strength)->name ?? 'Null',
            'category' => optional($this->medicine->pro_cat)->name ?? 'Null',
            'sub_category' => optional($this->medicine->pro_sub_cat)->name ?? 'Null',
        ];
    }

    /**
     * Generate description using the DescriptionGenerateService
     */
    private function generateDescription(array $data): array
    {
        try {
            $descriptionService = new DescriptionGenerateService();
            $result = $descriptionService->generateProductDescription($data);

            Log::info("Description generated successfully", [
                'medicine_id' => $this->medicine->id,
                'medicine_name' => $this->medicine->name,
                // 'result' => $result
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error("Description generation failed: " . $e->getMessage(), [
                'medicine_id' => $this->medicine->id,
                'medicine_name' => $this->medicine->name
            ]);
            throw new \RuntimeException("Description generation failed: " . $e->getMessage());
        }
    }

    private function updateMedicineDescription(array $generatedDescription): void
    {
        // Extract the product_description from the array
        $description = $generatedDescription['product_description'] ?? '';

        Log::info("Extracted Description",[
            'medicine_id' => $this->medicine->id,
            'medicine_name' => $this->medicine->name,
            // 'medicine-description' => $this->medicine->description,
        ]);

        // Update the medicine record
        $this->medicine->update([
            'description' => $description
        ]);

        Log::info("Medicine description updated successfully", [
            'medicine_id' => $this->medicine->id,
            'medicine_name' => $this->medicine->name,
            // 'medicine-description' => $this->medicine->description,
        ]);
    }


    /**
     * Handle any errors that occur during description generation
     */
    private function handleGenerationError(Throwable $e): void
    {
        Log::error("Description generation error occurred", [
            'medicine_id' => $this->medicine->id,
            'error_message' => $e->getMessage(),
            'error_code' => $e->getCode(),
            'error_file' => $e->getFile(),
            'error_line' => $e->getLine()
        ]);
    }
}
