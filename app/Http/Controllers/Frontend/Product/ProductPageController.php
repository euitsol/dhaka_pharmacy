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
        $query = Medicine::with(['company', 'generic', 'pro_cat', 'pro_sub_cat'])->activeted();
        $sub_cat_query = ProductSubCategory::with(['pro_cat'])->activeted();
        $query->when($category_slug !== 'all', fn ($q) => $q->whereHas('pro_cat', fn ($qs) => $qs->where('slug', $category_slug)));

        $query->when(($sub_category_slug !== null), fn ($q) => $q->whereHas('pro_sub_cat', fn ($qs) => $qs->where('slug', $sub_category_slug)));

        $sub_cat_query->when($category_slug !== 'all', fn ($q) => $q->whereHas('pro_cat', fn ($qs) => $qs->where('slug', $category_slug)));

        $data['products'] = $query->limit(1)->get()->shuffle()->map(function($product){
            $product->name = str_limit(Str::ucfirst(Str::lower($product->name)), 30, '..').'('.$product->pro_sub_cat->name.')';
            $product->generic->name = str_limit($product->generic->name, 30, '..');
            $product->company->name = str_limit($product->company->name, 30, '..');
            return $product;
        });
        $data['category'] = ProductCategory::with(['pro_sub_cats','medicines'])->activeted()->when($category_slug !== 'all', fn ($q) => $q->where('slug',$category_slug))->first();
        $data['sub_categories'] = $sub_cat_query->orderBy('name')->get();
        
        return view('frontend.product.product',$data);
    }
    public function sub_cat_products(){
        $currentUrl = URL::current();
        $category_slug = request('category');
        $sub_category_slug = request('sub-category');
        $data['url'] = $currentUrl . "&sub-category=$sub_category_slug";
         

        
        $query = Medicine::with(['company', 'generic', 'pro_cat', 'pro_sub_cat'])->activeted();
        $query->when($category_slug !== 'all', fn ($q) => $q->whereHas('pro_cat', fn ($qs) => $qs->where('slug', $category_slug)));
        $query->whereHas('pro_sub_cat', fn ($qs) => $qs->where('slug', $sub_category_slug));
        $data['products'] = $query->limit(1)->get()->shuffle()
                            ->map(function($product){
                                $product->image = storage_url($product->image);
                                $product->name = str_limit(Str::ucfirst(Str::lower($product->name)), 30, '..').'('.$product->pro_sub_cat->name.')';
                                $product->generic->name = str_limit($product->generic->name, 30, '..');
                                $product->company->name = str_limit($product->company->name, 30, '..');
                                return $product;
                            });
        return response()->json($data);
    }
    public function see_more(){

        $category_slug = request('category');
        $sub_category_slug = request('sub-category');
        $offset = request('offset');
        $query = Medicine::with(['company', 'generic', 'pro_cat', 'pro_sub_cat'])->activeted();
        $query->when($category_slug !== 'all', fn ($q) => $q->whereHas('pro_cat', fn ($qs) => $qs->where('slug', $category_slug)));
        $query->when(($sub_category_slug !== null), fn ($q) => $q->whereHas('pro_sub_cat', fn ($qs) => $qs->where('slug', $sub_category_slug)));
        $data['products'] = $query->offset($offset)->limit(1)->get()->shuffle()
                            ->map(function($product){
                                $product->image = storage_url($product->image);
                                $product->name = str_limit(Str::ucfirst(Str::lower($product->name)), 30, '..').'('.$product->pro_sub_cat->name.')';
                                $product->generic->name = str_limit($product->generic->name, 30, '..');
                                $product->company->name = str_limit($product->company->name, 30, '..');
                                return $product;
                            });
        return response()->json($data);
    }

}
