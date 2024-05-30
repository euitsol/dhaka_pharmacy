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
        // $products = Medicine::with('discounts')->activated()->latest()->get();
        // $similarProduct = clone $products;
        
        $data['single_product'] = Medicine::with('discounts')->activated()->where('slug',$slug)->first();
        $data['single_product']->discount_amount = calculateProductDiscount($data['single_product'],false);
        $data['single_product']->discount_percentage = calculateProductDiscount($data['single_product'], true);
        $data['single_product']->image = storage_url($data['single_product']->image);
        $data['units'] = $this->getSortedUnits($data['single_product']->unit);
        
        $data['similar_products'] = Medicine::with(['pro_cat','pro_sub_cat','generic','company','strength','discounts'])->activated()->latest()->where('generic_id',($data['single_product']->generic_id))->get()
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
