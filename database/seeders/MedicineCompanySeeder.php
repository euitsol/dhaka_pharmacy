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
            'slug' => 'sun-pharmaceutical-bangladesh-limited',
            ]);
        CompanyName::create([
            'name' => 'Incepta Pharmaceuticals Ltd.',
            'slug' => 'incepta-pharmaceuticals-ltd.',
            ]);
        CompanyName::create([
            'name' => 'RADIANT PHARMACEUTICALS LIMITED',
            'slug' => 'radiant-pharmaceuticals-limited',
            ]);
        CompanyName::create([
            'name' => 'ARISTOPHARMA LTD',
            'slug' => 'aristopharma-ltd',
            ]);
        CompanyName::create([
            'name' => 'SQUARE PHARMACEUTICALS LIMITED',
            'slug' => 'square-pharmaceuticals-limited',
            ]);
    }
}
