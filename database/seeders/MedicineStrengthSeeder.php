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
            'unit' => 'MG',
            ]);
        MedicineStrength::create([
            'quantity' => '10',
            'unit' => 'MG',
            ]);
        MedicineStrength::create([
            'quantity' => '10',
            'unit' => 'ML',
            ]);
        MedicineStrength::create([
            'quantity' => '20',
            'unit' => 'MG',
            ]);
        MedicineStrength::create([
            'quantity' => '20',
            'unit' => 'ML',
            ]);
        MedicineStrength::create([
            'quantity' => '30',
            'unit' => 'MG',
            ]);
        MedicineStrength::create([
            'quantity' => '30',
            'unit' => 'ML',
            ]);
        MedicineStrength::create([
            'quantity' => '40',
            'unit' => 'MG',
            ]);
        MedicineStrength::create([
            'quantity' => '40',
            'unit' => 'ML',
            ]);
        MedicineStrength::create([
            'quantity' => '50',
            'unit' => 'MG',
            ]);
        MedicineStrength::create([
            'quantity' => '50',
            'unit' => 'ML',
            ]);
        MedicineStrength::create([
            'quantity' => '100',
            'unit' => 'MG',
            ]);
        MedicineStrength::create([
            'quantity' => '100',
            'unit' => 'ML',
            ]);
        MedicineStrength::create([
            'quantity' => '200',
            'unit' => 'MG',
            ]);
        MedicineStrength::create([
            'quantity' => '200',
            'unit' => 'ML',
            ]);
        MedicineStrength::create([
            'quantity' => '300',
            'unit' => 'MG',
            ]);
        MedicineStrength::create([
            'quantity' => '300',
            'unit' => 'ML',
            ]);
        MedicineStrength::create([
            'quantity' => '400',
            'unit' => 'MG',
            ]);
        MedicineStrength::create([
            'quantity' => '400',
            'unit' => 'ML',
            ]);
        
        MedicineStrength::create([
            'quantity' => '500',
            'unit' => 'ML',
            ]);
    }
}
