<?php

namespace App\Services;

use App\Models\Product;
use App\Http\Traits\TransformProductTrait;

class ProductService
{
    use TransformProductTrait;
    public function modifyProduct($product)
    {
        return $this->transformProduct($product);
    }

}
