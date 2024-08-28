<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\MedicineUnitBkdn;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineUnitBkdnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // MedicineUnitBkdn::create([
        //     'unit_id' => 1,
        //     'medicine_id' => 1,
        // ]);
        // MedicineUnitBkdn::create([
        //     'unit_id' => 2,
        //     'medicine_id' => 1,
        // ]);
        // MedicineUnitBkdn::create([
        //     'unit_id' => 3,
        //     'medicine_id' => 1,
        // ]);
        $medicines = Medicine::all();

        // Loop through each medicine and create one or more MedicineUnitBkdn entries
        foreach ($medicines as $medicine) {
            // Generate a random number of MedicineUnitBkdn records for each medicine
            MedicineUnitBkdn::factory()->count(rand(1, 3))->create([
                'medicine_id' => $medicine->id,
            ]);
        }
    }
}