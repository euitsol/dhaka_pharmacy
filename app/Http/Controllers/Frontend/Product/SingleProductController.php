<?php

namespace App\Http\Controllers\Frontend\Product;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\MedicineUnit;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class SingleProductController extends Controller
{

    public function singleProduct($slug): View
    {
        
        
        $products = Medicine::with(['pro_cat','pro_sub_cat','generic','company','strength'])
                            ->where('status',1)
                            ->where('deleted_at',NULL);
        $data['single_product'] = Medicine::with(['pro_cat','pro_sub_cat','generic','company','strength'])->where('slug',$slug)->where('status',1)->where('deleted_at',null)->first();
        $data['units'] = array_map(function ($u) {
            $data =  MedicineUnit::findOrFail($u);
            return $data;
        }, (array) json_decode($data['single_product']->unit, true));
        $data['similar_products'] = $products->where('generic_id',$data['single_product']->generic_id)->latest()->get()->shuffle();
        // $data['products'] = $products->get()->shuffle()->take(8);
        // $data['bsItems'] = $products->where('is_best_selling', 1)->get()->shuffle()->take(8);

        $data['categories'] = ProductCategory::where('status',1)->where('deleted_at',NULL)->orderBy('name')->get();
        $data['menuItems'] = $data['categories']->where('is_menu',1);
        // $data['featuredItems'] = $data['categories']->where('is_featured',1);


        return view('frontend.product.single_product',$data);
    }
}
