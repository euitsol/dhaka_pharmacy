<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Medicine;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;


class HomePageController extends BaseController
{
    public function home():View
    {
        $products = Medicine::with(['pro_cat','pro_sub_cat','generic','company','strength'])->activated();
        $data['products'] = $products->latest()->get()->shuffle()->take(8)->map(function($product){
            $strength = $product->strength ? ' ('.$product->strength->quantity.' '.$product->strength->unit.')' : '' ;
            $product->attr_title = Str::ucfirst(Str::lower($product->name . $strength ));
            $product->name = str_limit(Str::ucfirst(Str::lower($product->name . $strength )), 30, '..');
            $product->generic->name = str_limit($product->generic->name, 30, '..');
            $product->company->name = str_limit($product->company->name, 30, '..');
            return $product;
        });
        $data['bsItems'] = $products->where('is_best_selling', 1)->latest()->get()->shuffle()->take(8)->map(function($product){
            $strength = $product->strength ? ' ('.$product->strength->quantity.' '.$product->strength->unit.')' : '' ;
            $product->attr_title = Str::ucfirst(Str::lower($product->name . $strength ));
            $product->name = str_limit(Str::ucfirst(Str::lower($product->name . $strength )), 30, '..');
            $product->generic->name = str_limit($product->generic->name, 30, '..');
            $product->company->name = str_limit($product->company->name, 30, '..');
            return $product;
        });

        $data['categories'] = ProductCategory::activated()->orderBy('name')->get();
        $data['featuredItems'] = $data['categories']->where('is_featured',1);

        return view('frontend.home',$data);
    }

    public function updateFeaturedProducts():JsonResponse
    {
        $category_slug = request('category');
        $currentUrl = URL::current();
        $data['url'] = $currentUrl . "?category=all";
        
        $products = Medicine::with(['pro_cat','pro_sub_cat','generic','company','strength'])->activated();
        $datas = $products->latest()->get();
        if($category_slug !== 'all'){
            $data['product_cat'] = ProductCategory::activated()->where('slug',$category_slug)->first();
            $data['url'] = $currentUrl . "?category=".$data['product_cat']->slug;
            $datas = $products->where('pro_cat_id',$data['product_cat']->id)->latest()->get();
        }
        $data['products'] = $datas->shuffle()->take(8)->map(function($product){
            $product->image = storage_url($product->image);
            $strength = $product->strength ? ' ('.$product->strength->quantity.' '.$product->strength->unit.')' : '' ;
            $product->attr_title = Str::ucfirst(Str::lower($product->name . $strength ));
            $product->name = str_limit(Str::ucfirst(Str::lower($product->name . $strength )), 30, '..');
            $product->generic->name = str_limit($product->generic->name, 30, '..');
            $product->company->name = str_limit($product->company->name, 30, '..');
            return $product;
        });
        return response()->json($data);
    }

    
}