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
        $query = Medicine::with(['company', 'generic', 'pro_cat', 'pro_sub_cat'])->where('status', 1)->where('deleted_at', null);
        if($cat_slug !=='all'){
            $data['category'] = ProductCategory::with(['pro_sub_cats','medicines'])
                                ->where('slug',$cat_slug)
                                ->where('status',1)
                                ->where('deleted_at',null)
                                ->first();

            $query = Medicine::with(['company', 'generic', 'pro_cat', 'pro_sub_cat'])
                                ->where('pro_cat_id', $data['category']->id)
                                ->where('status', 1)
                                ->where('deleted_at', null);

            if($sub_cat_slug != false){
                $data['sub_category'] = ProductSubCategory::where('slug',$sub_cat_slug)
                                        ->where('status',1)
                                        ->where('deleted_at',null)
                                        ->first();

                $query = $query->where('pro_sub_cat_id',$data['sub_category']->id );
            }
            $data['sub_categories'] = $data['category']->pro_sub_cats;
        }
        $data['products'] = $query->limit(1)->get()->shuffle();
        return view('frontend.product.product',$data);
    }
    public function sub_cat_products($cat_slug, $sub_cat_slug){
        $data['sub_category'] = ProductSubCategory::where('slug',$sub_cat_slug)
                                ->where('status',1)
                                ->where('deleted_at',null)
                                ->first();

        $query = Medicine::with(['company','generic','pro_cat','pro_sub_cat'])
                            ->where('pro_sub_cat_id',$data['sub_category']->id)
                            ->where('status',1)
                            ->where('deleted_at',null);
        if($cat_slug !=='all'){
            $data['category'] = ProductCategory::where('slug',$cat_slug)
                                ->where('status',1)
                                ->where('deleted_at',null)
                                ->first();
            $query = $query->where('pro_cat_id',$data['category']->id);
        }
        
        $data['products'] = $query->limit(1)->get()->shuffle()
        ->map(function($product){
            $product->image = storage_url($product->image);
            return $product;
        });
        return response()->json($data);
    }
    public function see_more($cat_slug, $offset, $sub_cat_slug = false){
        
        $query = Medicine::with(['company', 'generic', 'pro_cat', 'pro_sub_cat'])
                ->where('status', 1)
                ->where('deleted_at', null);
        if($cat_slug !=='all'){
            $data['category'] = ProductCategory::where('slug',$cat_slug)
                                ->where('status',1)
                                ->where('deleted_at',null)
                                ->first();
            $query = $query->where('pro_cat_id', $data['category']->id);
        }
        if($sub_cat_slug != false){
            $data['sub_category'] = ProductSubCategory::where('slug',$sub_cat_slug)
                                    ->where('status',1)
                                    ->where('deleted_at',null)
                                    ->first();
            $query = $query->where('pro_sub_cat_id',$data['sub_category']->id );
        }
        $data['products'] = $query
            ->offset($offset)
            ->limit(1)
            ->get()->shuffle()
            ->map(function($product){
                $product->image = storage_url($product->image);
                return $product;
            });
        return response()->json($data);
    }

}
