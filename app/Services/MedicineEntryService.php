<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\MedicineUnitBkdn;
use App\Models\Discount;
use App\Http\Requests\MedicineRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Services\FileUploadService;

class MedicineEntryService
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function storeMedicine(array $data)
    {
        try {
            Log::info('Storing medicine', ['data' => $data]);

            $data = $this->prepareData($data);

            $validator = Validator::make($data, (new MedicineRequest())->rules());

            if ($validator->fails()) {
                return [
                    'success' => false,
                    'errors' => $validator->errors()
                ];
            }

            DB::beginTransaction();

            try {
                $medicine = $this->createMedicine($data);
                $this->storeUnitPrices($medicine, $data['units']);
                $this->handleMedicineImage($medicine, $data['temp_file_id']);
                $this->handleDiscount($medicine, $data);

                DB::commit();
                Log::info('Medicine stored successfully', ['medicine_id' => $medicine->id]);

                return [
                    'success' => true,
                    'message' => 'Medicine created successfully',
                    'data' => $medicine
                ];
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Error storing medicine', ['exception' => $e->getMessage()]);
            return [
                'success' => false,
                'errors' => ['general' => $e->getMessage()]
            ];
        }
    }

    protected function prepareData(array $data): array
    {
        $data['slug'] = Str::slug($data['name']);
        return $data;
    }

    protected function validateData(array $data): bool
    {
        $validator = Validator::make($data, (new MedicineRequest())->rules());

        if ($validator->fails()) {
            Log::warning('Validation failed', ['errors' => $validator->errors()]);
            return false;
        }

        return true;
    }

    protected function createMedicine(array $data): Medicine
    {
        $medicine = Medicine::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'generic_id' => $data['generic_id'],
            'pro_cat_id' => $data['pro_cat_id'],
            'pro_sub_cat_id' => $data['pro_sub_cat_id'],
            'company_id' => $data['company_id'],
            'price' => $data['price'],
        ]);

        Log::info('Medicine created', ['medicine_id' => $medicine->id]);
        return $medicine;
    }

    protected function storeUnitPrices(Medicine $medicine, array $units): void
    {
        foreach ($units as $unit) {
            MedicineUnitBkdn::create([
                'medicine_id' => $medicine->id,
                'unit_id' => $unit['id'],
                'price' => $unit['price']
            ]);
        }
        Log::info('Units stored for medicine', ['medicine_id' => $medicine->id]);
    }

    protected function handleMedicineImage(Medicine $medicine, ?int $tempFileId): void
    {
        if (empty($tempFileId)) {
            return;
        }

        try {
            $imagePath = $this->fileUploadService->moveFromTemp(
                $tempFileId,
                'products/' . $medicine->slug,
                $medicine->slug . '_' . time()
            );

            if ($imagePath) {
                $medicine->image = $imagePath;
                $medicine->save();
            }
        } catch (\Exception $e) {
            Log::error('Error handling medicine image', [
                'medicine_id' => $medicine->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    protected function handleDiscount(Medicine $medicine, array $data): void
    {
        if (!($data['has_discount'] ?? false) || (isset($data['discount_amount']) && empty($data['discount_amount'])) && (isset($data['discount_percentage']) && empty($data['discount_percentage']))) {
            return;
        }

        $discount = Discount::create([
            'pro_id' => $medicine->id,
            'discount_amount' => $data['discount_amount'] ?? null,
            'discount_percentage' => $data['discount_percentage'] ?? null,
        ]);

        Log::info('Discount created', ['discount_id' => $discount->id]);
    }
}
