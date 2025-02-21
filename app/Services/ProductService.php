<?php

namespace App\Services;

use App\Models\Medicine;
use App\Http\Traits\TransformProductTrait;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    use TransformProductTrait;

    protected Medicine $product;

    public function setProduct(string $slug): self
    {
        $product = Medicine::where('slug', $slug)->activated()->first();
        if (!$product) {
           throw new \Exception(__('Product not found'));
        }
        $this->product = $product;
        return $this;
    }

    public function modifyProduct($product)
    {
        return $this->transformProduct($product);
    }


    public function details(): Medicine
    {
        $this->product->loadMissing(['pro_cat', 'pro_sub_cat', 'generic', 'company', 'strength', 'discounts', 'reviews.customer', 'units' => function ($q) {
            $q->orderBy('price', 'asc');
        }]);

        return $this->product;
    }

    public function relatedProducts(): Collection
    {
        $products = Medicine::with(['pro_cat', 'pro_sub_cat', 'generic', 'company', 'strength', 'discounts', 'units' => function ($q) {
            $q->orderBy('price', 'asc');
        }])->activated()->where('pro_cat_id', $this->product->pro_cat_id)->where('id', '!=', $this->product->id)->orderBy('price', 'asc')->limit(20)->get();

        return $products;
    }

    public function bestSellingProducts(): Collection
    {
        $products = Medicine::with(['pro_cat', 'pro_sub_cat', 'generic', 'company', 'strength', 'discounts', 'units' => function ($q) {
            $q->orderBy('price', 'asc');
        }])->activated()->bestSelling()->orderBy('price', 'asc')->limit(20)->get();

        return $products;
    }
}
