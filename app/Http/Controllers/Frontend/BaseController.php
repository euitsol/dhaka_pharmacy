<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AddToCart;
use App\Models\Medicine;
use App\Models\MedicineUnit;
use App\Models\ProductCategory;
use Illuminate\Contracts\Auth\Authenticatable;
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
        $data['menuItems'] = $data['categories']->where('is_menu', 1);
        
        $data['atcs'] = AddToCart::with(['product', 'customer'])
            ->where('customer_id', 1)
            ->latest()
            ->get();

        $data['atcs'] = $data['atcs']->map(function ($atc) {
            // Manipulating the 'product' relationship of each 'AddToCart' record
            $activatedProduct = $atc->product;
            if ($activatedProduct) {
                // Manipulating attributes for the activated product
                $strength = $activatedProduct->strength ? ' (' . $activatedProduct->strength->quantity . ' ' . $activatedProduct->strength->unit . ')' : '';
                $activatedProduct->attr_title = Str::ucfirst(Str::lower($activatedProduct->name . $strength));
                $activatedProduct->name = Str::limit(Str::ucfirst(Str::lower($activatedProduct->name . $strength)), 45, '..');
                $activatedProduct->generic->name = Str::limit($activatedProduct->generic->name, 55, '..');
                $activatedProduct->company->name = Str::limit($activatedProduct->company->name, 55, '..');

                $activatedProduct->units = array_map(function ($u_id) {
                    return MedicineUnit::findOrFail($u_id);
                }, (array) json_decode($activatedProduct->unit, true));

                $activatedProduct->units = collect($activatedProduct->units)->sortBy('quantity')->values()->all();
            }

            return $atc;
        });

        $data['total_cart_item'] = $data['atcs']->sum(function ($atc) {
            return $atc->product ? 1 : 0;
        });
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
        $unit_id = request('unit');




        $product = Medicine::activated()->where('slug',$product_slug)->first();
        $customer_id = 1;
        $check = AddToCart::where('product_id',$product->id)->where('customer_id',$customer_id)->first();
        if($check){
            $data['alert'] = "Already Add To Cart";
            return response()->json($data);
        }
        $data['alert'] = "Add To Cart Successfully";

        $atc = new AddToCart();
        $atc->product_id = $product->id;
        $atc->customer_id = $customer_id;
        $atc->unit_id = $unit_id;
        $atc->quantity = 1;
        $atc->save();

        $data['atcs'] = AddToCart::with(['product', 'customer'])
            ->where('customer_id', 1)
            ->latest()
            ->get();

        $data['atcs'] = $data['atcs']->map(function ($atc) {
            $activatedProduct = $atc->product;

            if ($activatedProduct) {
                $strength = $activatedProduct->strength ? ' (' . $activatedProduct->strength->quantity . ' ' . $activatedProduct->strength->unit . ')' : '';
                $activatedProduct->attr_title = Str::ucfirst(Str::lower($activatedProduct->name . $strength));
                $activatedProduct->name = Str::limit(Str::ucfirst(Str::lower($activatedProduct->name . $strength)), 45, '..');
                $activatedProduct->generic->name = Str::limit($activatedProduct->generic->name, 55, '..');
                $activatedProduct->company->name = Str::limit($activatedProduct->company->name, 55, '..');

                $activatedProduct->units = array_map(function ($u_id) {
                    return MedicineUnit::findOrFail($u_id);
                }, (array) json_decode($activatedProduct->unit, true));

                $activatedProduct->units = collect($activatedProduct->units)->sortBy('quantity')->values()->all();
            }

            return $atc;
        });

        $data['total_cart_item'] = $data['atcs']->sum(function ($atc) {
            return $atc->product ? 1 : 0;
        });

        return response()->json($data);
    }

    public function remove_to_cart(){
        $act_id = request('atc');
        $atc = AddToCart::findOrFail($act_id);
        $atc->delete();
        $data['sucses_alert'] = "Product Remove From Cart Successfully";

        $data['atcs'] = AddToCart::with(['product', 'customer'])
            ->where('customer_id', 1)
            ->latest()
            ->get();

        $data['atcs'] = $data['atcs']->map(function ($atc) {
            $activatedProduct = $atc->product;

            if ($activatedProduct) {
                $strength = $activatedProduct->strength ? ' (' . $activatedProduct->strength->quantity . ' ' . $activatedProduct->strength->unit . ')' : '';
                $activatedProduct->attr_title = Str::ucfirst(Str::lower($activatedProduct->name . $strength));
                $activatedProduct->name = Str::limit(Str::ucfirst(Str::lower($activatedProduct->name . $strength)), 45, '..');
                $activatedProduct->generic->name = Str::limit($activatedProduct->generic->name, 55, '..');
                $activatedProduct->company->name = Str::limit($activatedProduct->company->name, 55, '..');

                $activatedProduct->units = array_map(function ($u_id) {
                    return MedicineUnit::findOrFail($u_id);
                }, (array) json_decode($activatedProduct->unit, true));

                $activatedProduct->units = collect($activatedProduct->units)->sortBy('quantity')->values()->all();
            }

            return $atc;
        });

        $data['total_cart_item'] = $data['atcs']->sum(function ($atc) {
            return $atc->product ? 1 : 0;
        });

        return response()->json($data);
    }

}
