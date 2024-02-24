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
            'slug' => "otc-medicine",
            'is_featured' => 1,
            'is_menu' => 1,
            ]);
        ProductCategory::create([
            'name' => "Women's Choice",
            'slug' => "women's-choice",
            'is_featured' => 1,
            'is_menu' => 1,
            ]);
        ProductCategory::create([
            'name' => "Personal Care",
            'slug' => "personal-care",
            'is_featured' => 1,
            'is_menu' => 1,
            ]);
        ProductCategory::create([
            'name' => "Diabetic Care",
            'slug' => "diabetic-care",
            'is_featured' => 1,
            'is_menu' => 1,
            ]);
        ProductCategory::create([
            'name' => "Baby Care",
            'slug' => "baby-care",
            'is_featured' => 1,
            'is_menu' => 1,
            ]);
        ProductCategory::create([
            'name' => "Dental Care",
            'slug' => "dental-care",
            'is_featured' => 1,
            'is_menu' => 1,
            ]);
        ProductCategory::create([
            'name' => "Devices",
            'slug' => "devices",
            'is_featured' => 1,
            'is_menu' => 1,
            ]);
        ProductCategory::create([
            'name' => "Prescription Medicine",
            'slug' => "prescription-medicine",
            'is_featured' => 1,
            'is_menu' => 1,
            ]);
    }
}
