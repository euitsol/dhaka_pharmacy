<?php

namespace Database\Seeders;

use App\Models\MedicineUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineUnitSeeder extends Seeder
{
    public function run(): void
    {
        MedicineUnit::create([
            'name' => "Price",
            'quantity' => 1,
            ]);
        MedicineUnit::create([
            'name' => "10's Strip",
            'quantity' => 10,
            ]);
        MedicineUnit::create([
            'name' => "510's Pack",
            'quantity' => 510,
            ]);
        MedicineUnit::create([
            'name' => "100's Pack",
            'quantity' => 100,
            ]);
        MedicineUnit::create([
            'name' => "5's Strip",
            'quantity' => 5,
            ]);
        MedicineUnit::create([
            'name' => "200's Pack",
            'quantity' => 200,
            ]);
        MedicineUnit::create([
            'name' => "20's Strip",
            'quantity' => 20,
            ]);
        MedicineUnit::create([
            'name' => "60's Pack",
            'quantity' => 60,
            ]);
        MedicineUnit::create([
            'name' => "15's Strip",
            'quantity' => 15,
            ]);
        MedicineUnit::create([
            'name' => "150's Pack",
            'quantity' => 150,
            ]);
        MedicineUnit::create([
            'name' => "200 ml bottle",
            'quantity' => 1,
            ]);
        MedicineUnit::create([
            'name' => "250 ml bottle",
            'quantity' => 1,
            ]);

    }
}
