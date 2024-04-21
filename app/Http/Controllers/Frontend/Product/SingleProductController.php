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


class SingleProductController extends BaseController
{

    public function singleProduct($slug): View
    {
        $products = Medicine::with(['pro_cat','pro_sub_cat','generic','company','strength'])->activated();
        
        $data['single_product'] = Medicine::with(['pro_cat','pro_sub_cat','generic','company','strength'])->activated()->where('slug',$slug)->first();
        $data['single_product']->discount_amount = productDiscountAmount($data['single_product']->id);
        $data['single_product']->discount_percentage = productDiscountPercentage($data['single_product']->id);
        $units = array_map(function ($u) {
            return MedicineUnit::findOrFail($u);
        }, (array) json_decode($data['single_product']->unit, true));
        usort($units, function ($a, $b) {
            return $a->quantity - $b->quantity;
        });
        $data['units'] = $units;
        
        $data['similar_products'] = $products->where('generic_id',($data['single_product']->generic_id))->latest()->get()
        ->reject(function ($p) use ($data) {
            return $p->id == $data['single_product']->id;
        })->shuffle()->map(function($product){
            $strength = $product->strength ? ' ('.$product->strength->quantity.' '.$product->strength->unit.')' : '' ;
            $product->attr_title = Str::ucfirst(Str::lower($product->name . $strength ));
            $product->name = str_limit(Str::ucfirst(Str::lower($product->name . $strength )), 25, '..');
            $product->generic->name = str_limit($product->generic->name, 30, '..');
            $product->company->name = str_limit($product->company->name, 30, '..');
            $product->discount_amount = productDiscountAmount($product->id);
            $product->discount_percentage = productDiscountPercentage($product->id);
            $product->units = array_map(function ($u_id) {
                return MedicineUnit::findOrFail($u_id);
            }, (array) json_decode($product->unit, true));

            $product->units = collect($product->units)->sortBy('quantity')->values()->all();
            return $product;
        });
        return view('frontend.product.single_product',$data);
    }
}
