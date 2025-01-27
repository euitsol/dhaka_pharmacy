<?php

namespace App\Http\Traits;

use App\Models\MedicineUnit;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

trait TransformProductTrait
{
    private function transformProduct($product, $limit = 30)
    {
        $this->setStrengthInfo($product);
        $this->setProductNames($product, $limit);
        $this->setDiscountInformation($product);
        $this->setProductImage($product);

        return $product;
    }

    private function setProductImage(&$product)
    {
        $product->image = product_image($product->image);
    }

    private function setStrengthInfo(&$product)
    {
        $product->strength_info = $product->strength ? ' (' . Str::limit($product->strength->name, 10, '..') . ')' : '';
    }

    private function setProductNames(&$product, $limit)
    {
        Log::info('Generic Name Before:', ['name' => optional($product->generic)->name]);

        $product->attr_title = Str::ucfirst(Str::title($product->name));
        $product->name = Str::limit(Str::ucfirst(Str::lower($product->name . ($product->strength_info))), $limit, '..');
        optional($product->pro_cat)->name = Str::limit(Str::title(optional($product->pro_cat)->name), $limit, '..');
        optional($product->pro_sub_cat)->name = Str::limit(Str::title(optional($product->pro_sub_cat)->name), $limit, '..');
        optional($product->generic)->name = Str::limit(Str::title(optional($product->generic)->name), $limit, '..');
        optional($product->strength)->name = Str::limit(Str::title(optional($product->strength)->name), $limit, '..');
        optional($product->company)->name = Str::limit(Str::title(optional($product->company)->name), $limit, '..');

        Log::info('Generic Name After:', ['name' => Str::limit(Str::title(optional($product->generic)->name), $limit, '..')]);
    }

    private function setDiscountInformation(&$product)
    {
        $product->discount_amount = calculateProductDiscount($product, false);
        $product->discount_percentage = calculateProductDiscount($product, true);
        $product->discounted_price = proDisPrice($product->price, $product->discounts);
    }
}
