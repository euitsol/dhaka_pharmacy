<?php

namespace App\Http\Traits;

use App\Models\MedicineUnit;
use Illuminate\Support\Str;

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
        $product->strength_info = $product->strength ? ' (' . $product->strength->quantity . ' ' . $product->strength->unit . ')' : '';
    }

    private function setProductNames(&$product, $limit)
    {
        $product->attr_title = Str::ucfirst(Str::title($product->name));
        $product->name = Str::limit(Str::ucfirst(Str::lower($product->name . ($product->strength_info))), $limit, '..');
        $product->pro_sub_cat->name = Str::limit(Str::title($product->pro_sub_cat->name), $limit, '..');
        $product->generic->name = Str::limit(Str::title($product->generic->name), $limit, '..');
        $product->company->name = Str::limit(Str::title($product->company->name), $limit, '..');
    }

    private function setDiscountInformation(&$product)
    {
        $product->discount_amount = calculateProductDiscount($product, false);
        $product->discount_percentage = calculateProductDiscount($product, true);
        $product->discounted_price = proDisPrice($product->price, $product->discounts);
    }
}