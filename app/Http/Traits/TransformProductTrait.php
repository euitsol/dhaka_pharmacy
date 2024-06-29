<?php

namespace App\Http\Traits;

use App\Models\MedicineUnit;
use Illuminate\Support\Str;

trait TransformProductTrait
{

    // private function transformProduct($product, $limit)
    // {
    //     $product->image = product_image($product->image);
    //     $strength = $product->strength ? ' (' . $product->strength->quantity . ' ' . $product->strength->unit . ')' : '';
    //     $product->attr_title = Str::ucfirst(Str::lower($product->name . $strength));
    //     $product->name = Str::limit(Str::ucfirst(Str::lower($product->name . $strength)), $limit, '..');
    //     $product->generic->name = Str::limit($product->generic->name, $limit, '..');
    //     $product->company->name = Str::limit($product->company->name, $limit, '..');
    //     $product->discount_amount = calculateProductDiscount($product, false);
    //     $product->discount_percentage = calculateProductDiscount($product, true);
    //     $product->discountPrice = proDisPrice($product->price, $product->discounts);
    //     return $product;
    // }

    // private function getSortedUnits($unitJson)
    // {
    //     $unitIds = (array) json_decode($unitJson, true);
    //     $units = MedicineUnit::whereIn('id', $unitIds)->get()->each(function ($unit) {
    //         $unit->image = product_image($unit->image);
    //         return $unit;
    //     })->sortBy('quantity')->values()->all();
    //     return $units;
    // }


private function transformProduct($product, $limit = 30)
    {
        $this->setProductImage($product);
        $this->setStrengthInfo($product);
        $this->setProductNames($product, $limit);
        $this->setDiscountInformation($product);

        return $product;
    }

    private function setProductImage(&$product)
    {
        $product->image = product_image($product->image);
    }

    private function setStrengthInfo(&$product)
    {
        $product->strength_info = $product->strength ? ' (' . $product->strength->quantity . ' ' . $product->strength->unit . ')' : '';

    }

    private function setProductNames(&$product, $limit)
    {
        $product->name = Str::limit(Str::ucfirst(Str::lower($product->name . ($product->strength_info))), $limit, '..');
        $product->generic->name = Str::limit(Str::title($product->generic->name), $limit, '..');
        $product->company->name = Str::limit(Str::title($product->company->name), $limit, '..');
        $product->attr_title = Str::ucfirst(Str::lower($product->name));
    }

    private function setDiscountInformation(&$product)
    {
        $product->discount_amount = calculateProductDiscount($product, false);
        $product->discount_percentage = calculateProductDiscount($product, true);
        $product->discounted_price = proDisPrice($product->price, $product->discounts);
    }
}
