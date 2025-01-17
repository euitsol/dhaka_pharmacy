<?php

namespace Database\Seeders;

use App\Models\MedicineStrength;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineStrengthSeeder extends Seeder
{

    public function run(): void
    {
        MedicineStrength::create([
            'name' => '10 mg',
        ]);
        MedicineStrength::create([
            'name' => '10 ml',
        ]);
        MedicineStrength::create([
            'name' => '20 mg',
        ]);
        MedicineStrength::create([
            'name' => '20 ml',
        ]);
        MedicineStrength::create([
            'name' => '30 mg',
        ]);
        MedicineStrength::create([
            'name' => '30 ml',
        ]);
        MedicineStrength::create([
            'name' => '40 mg',
        ]);
        MedicineStrength::create([
            'name' => '40 ml',
        ]);
        MedicineStrength::create([
            'name' => '50 mg',
        ]);
        MedicineStrength::create([
            'name' => '50 ml',
        ]);
        MedicineStrength::create([
            'name' => '100 mg',
        ]);
        MedicineStrength::create([
            'name' => '100 ml',
        ]);
        MedicineStrength::create([
            'name' => '200 mg',
        ]);
        MedicineStrength::create([
            'name' => '200 ml',
        ]);
        MedicineStrength::create([
            'name' => '300 mg',
        ]);
        MedicineStrength::create([
            'name' => '300 ml',
        ]);
        MedicineStrength::create([
            'name' => '400 mg',
        ]);
        MedicineStrength::create([
            'name' => '400 ml',
        ]);
        MedicineStrength::create([
            'name' => '500 mg',
        ]);
        MedicineStrength::create([
            'name' => '500 ml',
        ]);
    }
}
