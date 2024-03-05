<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AddToCart;
use App\Models\Medicine;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Str;


class BaseController extends Controller
{
    public function __construct() {
        $data['categories'] = ProductCategory::activated()->orderBy('name')->get();
        $data['menuItems'] = $data['categories']->where('is_menu',1);


        // Cart 
            $data['atcs'] = AddToCart::with(['product', 'customer'])
            ->where('customer_id',1)
            ->latest()
            ->get();
            $data['products'] = Medicine::activated()
                            ->whereIn('id', $data['atcs']->pluck('product_id'))
                            ->get();
            $data['total_cart_item'] = $data['products']->count();
        
        view()->share($data);
    }

    public function productSearch($search_value, $category){
        $filter = Medicine::with(['pro_sub_cat','generic','company','strength']);
        if($category !== 'all'){
            $filter = $filter->where('pro_cat_id',$category);
        }
        $data['products'] = $filter->where(function ($query) use ($search_value) {
            $query->whereHas('generic', function ($query) use ($search_value) {
                    $query->where('name', 'like', '%' . $search_value . '%')
                        ->activated();
                })
                ->orWhereHas('company', function ($query) use ($search_value) {
                    $query->where('name', 'like', '%' . $search_value . '%')
                        ->activated();
                })
                ->orWhereHas('pro_sub_cat', function ($query) use ($search_value) {
                    $query->where('name', 'like', '%' . $search_value . '%')
                        ->activated();
                })
                ->orWhere('name', 'like', '%' . $search_value . '%');
        })
        ->get()->map(function ($product) {
            $product->image = storage_url($product->image);
            $strength = $product->strength ? ' ('.$product->strength->quantity.' '.$product->strength->unit.')' : '' ;
            $product->name = str_limit(Str::ucfirst(Str::lower($product->name . $strength )));
            $product->generic->name =(Str::ucfirst(Str::lower($product->generic->name)));
            $product->company->name =(Str::ucfirst(Str::lower($product->company->name)));
            $product->pro_sub_cat->name =(Str::ucfirst(Str::lower($product->pro_sub_cat->name)));
            return $product;
        });
        return response()->json($data);
    }

    public function add_to_cart(){
        $product_slug = request('product');
        $product = Medicine::activated()->where('slug',$product_slug)->first();
        $customer_id = user()->id;
        $check = AddToCart::where('product_id',$product->id)->where('customer_id',$customer_id)->first();
        $data['alert'] = null;
        if($check){
            $data['alert'] = "Already Add To Cart";
            return response()->json($data);
        }
        $atc = new AddToCart();
        $atc->product_id = $product->id;
        $atc->customer_id = $customer_id;
        $atc->quantity = 1;
        $atc->save();

        $data['atcs'] = AddToCart::with(['product', 'customer'])
                        ->where('customer_id', 1)
                        ->latest()
                        ->get();
        $data['products'] = Medicine::activated()
                            ->whereIn('id', $data['atcs']->pluck('product_id'))
                            ->get();
        $data['total_cart_item'] = $data['products']->count();
        return response()->json($data);



    }
}
