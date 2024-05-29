<?php

namespace App\Http\Controllers\Frontend\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Models\Medicine;
use App\Models\MedicineUnit;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Http\Traits\TransformProductTrait;


class SingleProductController extends BaseController
{
    use TransformProductTrait;

    public function singleProduct($slug): View
    {
        $products = Medicine::with(['pro_cat','pro_sub_cat','generic','company','strength','discounts'])->activated();
        
        $data['single_product'] = $products->where('slug',$slug)->first();
        $data['single_product']->discount_amount = calculateProductDiscount($data['single_product'],false);
        $data['single_product']->discount_percentage = calculateProductDiscount($data['single_product'], true);
        $data['units'] = $this->getSortedUnits($data['single_product']->unit);
        
        $data['similar_products'] = $products->where('generic_id',($data['single_product']->generic_id))->latest()->get()
        ->reject(function ($p) use ($data) {
            return $p->id == $data['single_product']->id;
        })->shuffle()->each(function($product){
            $product = $this->transformProduct($product,30);
            $product->units = $this->getSortedUnits($product->unit);
            return $product;
        });
        return view('frontend.product.single_product',$data);
    }
}
