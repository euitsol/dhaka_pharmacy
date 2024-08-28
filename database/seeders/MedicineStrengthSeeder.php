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
            'quantity' => '500',
            'unit' => 'mg',
        ]);
        MedicineStrength::create([
            'quantity' => '10',
            'unit' => 'mg',
        ]);
        MedicineStrength::create([
            'quantity' => '10',
            'unit' => 'ml',
        ]);
        MedicineStrength::create([
            'quantity' => '20',
            'unit' => 'mg',
        ]);
        MedicineStrength::create([
            'quantity' => '20',
            'unit' => 'ml',
        ]);
        MedicineStrength::create([
            'quantity' => '30',
            'unit' => 'mg',
        ]);
        MedicineStrength::create([
            'quantity' => '30',
            'unit' => 'ml',
        ]);
        MedicineStrength::create([
            'quantity' => '40',
            'unit' => 'mg',
        ]);
        MedicineStrength::create([
            'quantity' => '40',
            'unit' => 'ml',
        ]);
        MedicineStrength::create([
            'quantity' => '50',
            'unit' => 'mg',
        ]);
        MedicineStrength::create([
            'quantity' => '50',
            'unit' => 'ml',
        ]);
        MedicineStrength::create([
            'quantity' => '100',
            'unit' => 'mg',
        ]);
        MedicineStrength::create([
            'quantity' => '100',
            'unit' => 'ml',
        ]);
        MedicineStrength::create([
            'quantity' => '200',
            'unit' => 'mg',
        ]);
        MedicineStrength::create([
            'quantity' => '200',
            'unit' => 'ml',
        ]);
        MedicineStrength::create([
            'quantity' => '300',
            'unit' => 'mg',
        ]);
        MedicineStrength::create([
            'quantity' => '300',
            'unit' => 'ml',
        ]);
        MedicineStrength::create([
            'quantity' => '400',
            'unit' => 'mg',
        ]);
        MedicineStrength::create([
            'quantity' => '400',
            'unit' => 'ml',
        ]);

        MedicineStrength::create([
            'quantity' => '500',
            'unit' => 'ml',
        ]);
    }
}