<?php

namespace App\Http\Traits;

use App\Models\MedicineUnit;
use Illuminate\Support\Str;

trait TransformProductTrait{

    private function transformProduct($product, $limit)
    {
        $product->image = storage_url($product->image);
        $strength = $product->strength ? ' (' . $product->strength->quantity . ' ' . $product->strength->unit . ')' : '';
        $product->attr_title = Str::ucfirst(Str::lower($product->name . $strength));
        $product->name = Str::limit(Str::ucfirst(Str::lower($product->name . $strength)), $limit, '..');
        $product->generic->name = Str::limit($product->generic->name, $limit, '..');
        $product->company->name = Str::limit($product->company->name, $limit, '..');
        $product->discount_amount = calculateProductDiscount($product, false);
        $product->discount_percentage = calculateProductDiscount($product, true);
        $product->discountPrice = $product->discountPrice();
        return $product;
    }
    private function getSortedUnits($unitJson)
    {
        $unitIds = (array) json_decode($unitJson, true);
        $units = MedicineUnit::whereIn('id', $unitIds)->get()->each(function($unit){
            $unit->image = storage_url($unit->image);
            return $unit;
        })->sortBy('quantity')->values()->all();
        return $units;
    }
}
