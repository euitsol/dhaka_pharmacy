<?php

namespace Database\Seeders;

use App\Models\MedicineCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineCategorySeeder extends Seeder
{

    public function run(): void
    {
        MedicineCategory::create([
            'name' => 'Tablet',
            ]);
        MedicineCategory::create([
            'name' => 'Capsule',
            ]);
        MedicineCategory::create([
            'name' => 'Syrup',
            ]);
        MedicineCategory::create([
            'name' => 'Injection',
            ]);
        MedicineCategory::create([
            'name' => 'Ointment',
            ]);
    }
}
