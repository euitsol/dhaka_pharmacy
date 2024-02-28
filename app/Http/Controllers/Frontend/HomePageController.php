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
        $products = Medicine::with(['pro_cat','pro_sub_cat','generic','company','strength'])
                            ->where('status',1)
                            ->where('deleted_at',NULL);
        $data['products'] = $products->latest()->get()->shuffle()->take(8);
        $data['bsItems'] = $products->where('is_best_selling', 1)->latest()->get()->shuffle()->take(8);

        $data['categories'] = ProductCategory::where('status',1)->where('deleted_at',NULL)->orderBy('name')->get();
        $data['menuItems'] = $data['categories']->where('is_menu',1);
        $data['featuredItems'] = $data['categories']->where('is_featured',1);

        return view('frontend.home',$data);
    }

    public function updateFeaturedProducts($id){
        $products = Medicine::with(['pro_cat','pro_sub_cat','generic','company','strength'])
                            ->where('status',1)
                            ->where('deleted_at',NULL);
        $datas = $products->latest()->get();
        if($id != 'all'){
            $datas = $products->where('pro_cat_id',$id)->latest()->get();
        }
        $datas = $datas->map(function($data){
                $data->image = ($data->image ? storage_url($data->image) : '');
                return $data;
        });
        $data['products'] = $datas->shuffle()->take(8)->map(function($product){
            $product->name = str_limit($product->name. '('.$product->pro_sub_cat->name.')', 25, '..');
            $product->generic->name = str_limit($product->generic->name, 25, '..');
            $product->company->name = str_limit($product->company->name, 25, '..');
            return $product;
        });
        return response()->json($data);
    }

    public function productSearch($search_value, $category = false){
        $filter = Medicine::whereHas('generic', function ($query) use ($search_value) {
            $query->where('name', 'like', '%' . $search_value . '%')
                ->where('status',1);
        })
        ->orwhereHas('company', function ($query) use ($search_value) {
            $query->where('name', 'like', '%' . $search_value . '%')
                ->where('status',1);
        })
        ->orwhereHas('pro_sub_cat', function ($query) use ($search_value) {
            $query->where('name', 'like', '%' . $search_value . '%')
                ->where('status',1);
        })
        ->orWhere('name', 'like', '%' . $search_value . '%')
        ->with(['pro_cat','pro_sub_cat','generic','company','strength']);

        if($category !== 'all'){
            $data['products'] = $filter
            ->where('pro_cat_id',$category)
            ->get();
        }else{
            $data['products'] = $filter->get();
        }

        
        return response()->json($data);
    }
}