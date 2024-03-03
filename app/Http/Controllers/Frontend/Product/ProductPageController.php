<?php

namespace App\Http\Controllers\Frontend\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Models\Medicine;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class ProductPageController extends BaseController
{
    public function products($cat_slug, $sub_cat_slug = false){
        $data['category'] = ProductCategory::with(['pro_sub_cats','medicines'])->where('slug',$cat_slug)->where('status',1)->where('deleted_at',null)->first();
        $data['products'] = $data['category']->medicines;
        if($sub_cat_slug != false){
            $data['sub_category'] = ProductSubCategory::where('slug',$sub_cat_slug)->where('status',1)->where('deleted_at',null)->first();
            $data['products'] = $data['products']->where('pro_sub_cat_id',$data['sub_category']->id );
        }
        $data['products'] = $data['products']->shuffle()->take(18);
        $data['sub_categories'] = $data['category']->pro_sub_cats;
        
        // $data['sub_categories'] = ProductSubCategory::all();
        // $data['products'] = Medicine::all()->shuffle()->take(18);
        return view('frontend.product.product',$data);
    }
    public function sub_cat_products($cat_slug, $sub_cat_slug){
        $category = ProductCategory::where('slug',$cat_slug)->where('status',1)->where('deleted_at',null)->first();
        $sub_category = ProductSubCategory::where('slug',$sub_cat_slug)->where('status',1)->where('deleted_at',null)->first();

        $data['products'] = Medicine::with(['company','generic','pro_cat','pro_sub_cat'])->where('pro_cat_id',$category->id)->where('pro_sub_cat_id',$sub_category->id)->where('status',1)->where('deleted_at',null)->get()->shuffle()->take(18)
        ->map(function($product){
            $product->image = storage_url($product->image);
            return $product;
        });
        // $data['sub_categories'] = ProductSubCategory::all();
        // $data['products'] = Medicine::all()->shuffle()->take(18);
        return response()->json($data);
    }
}
