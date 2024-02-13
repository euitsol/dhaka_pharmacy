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
        $products = Medicine::with(['pro_cat','pro_sub_cat','generic','company','medicine_cat','strength'])
                            ->where('status',1)
                            ->where('deleted_at',NULL);
        $data['categories'] = ProductCategory::where('status',1)->where('deleted_at',NULL)->orderBy('name')->get();
        $data['products'] = $products->get()->shuffle()->take(8);

        $data['menuItems'] = $data['categories']->where('is_menu',1);
        $data['featuredItems'] = $data['categories']->where('is_featured',1);
        $data['bsItems'] = $products->where('is_best_selling',1)->inRandomOrder()->limit(8)->get();

        $data['bsItems'] = $products->where('is_best_selling', 1)->get()->shuffle()->take(8);

        return view('frontend.home',$data);
    }

    public function updateFeaturedProducts($id){
        $products = Medicine::with(['pro_cat','pro_sub_cat','generic','company','medicine_cat','strength'])
                            ->where('status',1)
                            ->where('deleted_at',NULL);
        $datas = $products->get();
        if($id != 'all'){
            $datas = $products->where('pro_cat_id',$id)->get();
        }
        $datas = $datas->map(function($data){
                $data->image = ($data->image ? storage_url($data->image) : '');
                return $data;
        });
        $data['products'] = $datas->shuffle()->take(8);
        return response()->json($data);
    }
}