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
                'result' => $result
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
        // Format the description as HTML
        $formattedDescription = $this->formatDescription($generatedDescription);

        // Update the medicine record
        $this->medicine->update([
            'description' => $formattedDescription
        ]);

        Log::info("Medicine description updated successfully", [
            'medicine_id' => $this->medicine->id,
            'medicine_name' => $this->medicine->name
        ]);
    }

    /**
     * Format the description as HTML
     */
    private function formatDescription(array $description): string
    {
        $html = '';

        // Introduction
        if (!empty($description['introduction'])) {
            $html .= "<h3>Introduction</h3>";
            $html .= "<p>{$description['introduction']}</p>";
        }

        // Indication
        if (!empty($description['indication'])) {
            $html .= "<h3>Indication</h3>";
            $html .= "<p>{$description['indication']}</p>";
        }

        // How to use
        if (!empty($description['how_to_use'])) {
            $html .= "<h3>How to Use</h3>";
            $html .= "<p>{$description['how_to_use']}</p>";
        }

        // Pharmacology
        if (!empty($description['pharmacology'])) {
            $html .= "<h3>Pharmacology</h3>";
            $html .= "<p>{$description['pharmacology']}</p>";
        }

        // Administration & Dosage
        if (!empty($description['administration_dosage'])) {
            $html .= "<h3>Administration & Dosage</h3>";

            if (!empty($description['administration_dosage']['adult_dose'])) {
                $html .= "<h4>Adult Dose</h4>";
                $html .= "<p>{$description['administration_dosage']['adult_dose']}</p>";
            }

            if (!empty($description['administration_dosage']['child_dose'])) {
                $html .= "<h4>Child Dose</h4>";
                $html .= "<p>{$description['administration_dosage']['child_dose']}</p>";
            }

            if (!empty($description['administration_dosage']['others_dose'])) {
                $html .= "<h4>Other Dosage Information</h4>";
                $html .= "<p>{$description['administration_dosage']['others_dose']}</p>";
            }
        }

        // Mode of Action
        if (!empty($description['mode_of_action'])) {
            $html .= "<h3>Mode of Action</h3>";
            $html .= "<p>{$description['mode_of_action']}</p>";
        }

        // Interaction
        if (!empty($description['interaction'])) {
            $html .= "<h3>Drug Interactions</h3>";
            $html .= "<p>{$description['interaction']}</p>";
        }

        // Contraindication
        if (!empty($description['contraindication'])) {
            $html .= "<h3>Contraindications</h3>";
            $html .= "<p>{$description['contraindication']}</p>";
        }

        // Precaution & Warnings
        if (!empty($description['precaution_warnings'])) {
            $html .= "<h3>Precautions & Warnings</h3>";
            $html .= "<p>{$description['precaution_warnings']}</p>";
        }

        // Pregnancy & Lactation
        if (!empty($description['pregnancy_lactation'])) {
            $html .= "<h3>Pregnancy & Lactation</h3>";
            $html .= "<p>{$description['pregnancy_lactation']}</p>";
        }

        // Side Effects
        if (!empty($description['side_effects'])) {
            $html .= "<h3>Side Effects</h3>";
            $html .= "<p>{$description['side_effects']}</p>";
        }

        // Storage
        if (!empty($description['storage'])) {
            $html .= "<h3>Storage</h3>";
            $html .= "<p>{$description['storage']}</p>";
        }

        return $html;
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
