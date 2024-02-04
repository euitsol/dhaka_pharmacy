<?php

namespace Database\Seeders;

use App\Models\CompanyName;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineCompanySeeder extends Seeder
{

    public function run(): void
    {
        CompanyName::create([
            'name' => 'SUN PHARMACEUTICAL BANGLADESH LIMITED',
            ]);
        CompanyName::create([
            'name' => 'Incepta Pharmaceuticals Ltd.',
            ]);
        CompanyName::create([
            'name' => 'RADIANT PHARMACEUTICALS LIMITED',
            ]);
        CompanyName::create([
            'name' => 'ARISTOPHARMA LTD',
            ]);
        CompanyName::create([
            'name' => 'SQUARE PHARMACEUTICALS LIMITED',
            ]);
    }
}
