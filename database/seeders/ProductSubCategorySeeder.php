<?php

namespace Database\Seeders;

use App\Models\ProductSubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductSubCategory::create([
            'name' => "Sub Category-1",
            'slug' => "sub-category-1",
            'pro_cat_id' => "1",
            ]);
        ProductSubCategory::create([
            'name' => "Sub Category-2",
            'slug' => "sub-category-2",
            'pro_cat_id' => "2",
            ]);
        ProductSubCategory::create([
            'name' => "Sub Category-3",
            'slug' => "sub-category-3",
            'pro_cat_id' => "3",
            ]);
        ProductSubCategory::create([
            'name' => "Sub Category-4",
            'slug' => "sub-category-4",
            'pro_cat_id' => "1",
            ]);
        ProductSubCategory::create([
            'name' => "Sub Category-5",
            'slug' => "sub-category-5",
            'pro_cat_id' => "2",
            ]);
        ProductSubCategory::create([
            'name' => "Sub Category-6",
            'slug' => "sub-category-6",
            'pro_cat_id' => "3",
            ]);
    }
}
