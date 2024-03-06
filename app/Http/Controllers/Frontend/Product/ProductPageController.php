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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;


class ProductPageController extends BaseController
{
    public function products(){
        $category_slug = request('category');
        $sub_category_slug = request('sub-category');
        $offset = request('offset');

        $currentUrl = URL::current();
        $data['url'] = $currentUrl . "?category=$category_slug&sub-category=$sub_category_slug";




        $data['sub_category'] =  ProductSubCategory::where('slug',$sub_category_slug)->activated()->first();
        $query = Medicine::with(['company', 'generic', 'pro_cat', 'pro_sub_cat'])->activated();
        $sub_cat_query = ProductSubCategory::with(['pro_cat'])->activated();
        $query->when($category_slug !== 'all', fn ($q) => $q->whereHas('pro_cat', fn ($qs) => $qs->where('slug', $category_slug)));

        $query->when(($sub_category_slug !== null), fn ($q) => $q->whereHas('pro_sub_cat', fn ($qs) => $qs->where('slug', $sub_category_slug)));
        $query->when(($offset !== null), fn ($q) => $q->offset($offset)->limit(1));
        $sub_cat_query->when($category_slug !== 'all', fn ($q) => $q->whereHas('pro_cat', fn ($qs) => $qs->where('slug', $category_slug)));

        $data['products'] = $query->limit(1)->get()->shuffle()->map(function($product){
            $product->ajax_image = storage_url($product->image);
            $strength = $product->strength ? ' ('.$product->strength->quantity.' '.$product->strength->unit.')' : '' ;
            $product->attr_title = Str::ucfirst(Str::lower($product->name . $strength ));
            $product->name = str_limit(Str::ucfirst(Str::lower($product->name . $strength )), 30, '..');
            $product->generic->name = str_limit($product->generic->name, 30, '..');
            $product->company->name = str_limit($product->company->name, 30, '..');
            return $product;
        });
        if($category_slug !== 'all'){
            $data['category'] = ProductCategory::with(['pro_sub_cats','medicines'])->activated()->where('slug',$category_slug)->first();
        }
        
        $data['sub_categories'] = $sub_cat_query->orderBy('name')->get()->groupBy('pro_cat.name');
        // dd($data['sub_categories']);
        if (request()->ajax()) {
            return response()->json($data);
        }else{
            return view('frontend.product.product',$data);
        }
        
    }
}
