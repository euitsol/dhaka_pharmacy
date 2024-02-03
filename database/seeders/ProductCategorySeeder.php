<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        ProductCategory::create([
            'name' => "OTC Medicine",
            ]);
        ProductCategory::create([
            'name' => "Women's Choice",
            ]);
        ProductCategory::create([
            'name' => "Personal Care",
            ]);
        ProductCategory::create([
            'name' => "Diabetic Care",
            ]);
        ProductCategory::create([
            'name' => "Baby Care",
            ]);
        ProductCategory::create([
            'name' => "Dental Care",
            ]);
    }
}
