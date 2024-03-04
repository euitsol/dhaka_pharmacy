<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Medicine;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;


class HomePageController extends BaseController
{
    public function home():View
    {
        $products = Medicine::with(['pro_cat','pro_sub_cat','generic','company','strength'])
                            ->where('status',1)
                            ->where('deleted_at',NULL);
        $data['products'] = $products->latest()->get()->shuffle()->take(8)->map(function($product){
            $product->name = str_limit(Str::ucfirst(Str::lower($product->name)), 30, '..').'('.$product->pro_sub_cat->name.')';
            $product->generic->name = str_limit($product->generic->name, 30, '..');
            $product->company->name = str_limit($product->company->name, 30, '..');
            return $product;
        });
        $data['bsItems'] = $products->where('is_best_selling', 1)->latest()->get()->shuffle()->take(8);

        $data['categories'] = ProductCategory::where('status',1)->where('deleted_at',NULL)->orderBy('name')->get();
        // $data['menuItems'] = $data['categories']->where('is_menu',1);
        $data['featuredItems'] = $data['categories']->where('is_featured',1);

        return view('frontend.home',$data);
    }

    public function updateFeaturedProducts($id):JsonResponse
    {
        
        $products = Medicine::with(['pro_cat','pro_sub_cat','generic','company','strength'])
                            ->where('status',1)
                            ->where('deleted_at',NULL);
        $datas = $products->latest()->get();
        if($id != 'all'){
            $data['product_cat'] = ProductCategory::findOrFail($id);
            $datas = $products->where('pro_cat_id',$id)->latest()->get();
        }
        $datas = $datas->map(function($data){
                $data->image = storage_url($data->image);
                return $data;
        });
        $data['products'] = $datas->shuffle()->take(8)->map(function($product){
            $product->name = str_limit(Str::ucfirst(Str::lower($product->name)), 30, '..').'('.$product->pro_sub_cat->name.')';
            $product->generic->name = str_limit($product->generic->name, 30, '..');
            $product->company->name = str_limit($product->company->name, 30, '..');
            return $product;
        });
        return response()->json($data);
    }

    
}