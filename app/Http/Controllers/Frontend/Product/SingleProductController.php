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


class SingleProductController extends BaseController
{

    public function singleProduct($slug): View
    {
        $products = Medicine::with(['pro_cat','pro_sub_cat','generic','company','strength'])->activeted();
        $data['single_product'] = $products->where('slug',$slug)->first();
        $units = array_map(function ($u) {
            return MedicineUnit::findOrFail($u);
        }, (array) json_decode($data['single_product']->unit, true));
        usort($units, function ($a, $b) {
            return $a->quantity - $b->quantity;
        });
        $data['units'] = $units;
        $data['similar_products'] = $products->where('generic_id',$data['single_product']->generic_id)->latest()->get()
        ->reject(function ($product) use ($data) {
            return $product->id == $data['single_product']->id;
        })->shuffle();
        return view('frontend.product.single_product',$data);
    }
}
