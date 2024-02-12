<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Medicine;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class HomePageController extends BaseController
{
    public function home(){
        $data['categories'] = ProductCategory::where('status',1)->where('deleted_at',NULL)->orderBy('name')->get();
        $data['products'] = Medicine::where('status',1)->where('deleted_at',NULL)->latest()->limit(8)->get();
        $data['menuItems'] = $data['categories']->where('is_menu',1);
        $data['featuredItems'] = $data['categories']->where('is_featured',1);
        return view('frontend.home',$data);
    }
    public function updateFeaturedProducts($id){

        $products = Medicine::where('status',1)->where('deleted_at',NULL);
        $data['products'] = $products->latest()->limit(8)->get();
        if($id != 'all'){
            $data['products'] = $products->where('pro_cat_id',$id)->latest()->limit(8)->get();
        }
        return response()->json($data);
    }
}