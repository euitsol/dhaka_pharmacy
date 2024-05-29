<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AddToCart;
use App\Models\Medicine;
use App\Models\MedicineUnit;
use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Str;


class BaseController extends Controller
{
    public function productSearch($search_value, $category):JsonResponse
    {
        $filter = Medicine::with(['pro_sub_cat','generic','company','strength','discounts']);
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
            return $this->transformProduct($product, 30);
        });
        return response()->json($data);
    }

    public function add_to_cart():JsonResponse
    {
        $product_slug = request('product');
        $unit_id = request('unit');



        $product = Medicine::activated()->where('slug',$product_slug)->first();
        $customer_id = user()->id;
        $data['count'] = AddToCart::where('customer_id',$customer_id)->count();
        $atc = AddToCart::where('product_id',$product->id)->where('customer_id',$customer_id)->first();
        if($atc){
            if($atc->status !== 1){
                $atc->status = 1;
                $atc->unit_id = $unit_id;
                $atc->created_at = Carbon::now();
                $atc->save();
            }else{
                $data['alert'] = "The item has already been added to the cart";
                return response()->json($data);
            }
        }else{
            $atc = new AddToCart();
            $atc->product_id = $product->id;
            $atc->customer_id = $customer_id;
            $atc->unit_id = $unit_id;
            $atc->quantity = 1;
            $atc->save();
        }




        $data['alert'] = "The item has been successfully added to your cart";
        $data['atc'] = AddToCart::with(['product.generic','product.pro_sub_cat','product.company','product.discounts'])->where('product_id',$atc->product_id)->where('customer_id',$atc->customer_id)->first();
        $activatedProduct = $data['atc']->product;

        if ($activatedProduct) {
            $activatedProduct = $this->transformProduct($activatedProduct, 45);
            
            $activatedProduct->data_item_price = (!empty($data['atc']->unit_id)) ? ($data['atc']->product->price*$data['atc']->unit->quantity) : $data['atc']->product->price;
            $activatedProduct->data_item_discount_price = (!empty($data['atc']->unit_id)) ? ($data['atc']->product->discountPrice()*$data['atc']->unit->quantity) : $data['atc']->product->discountPrice();
            $activatedProduct->discount = calculateProductDiscount($activatedProduct, true) ? true : false;

            $activatedProduct->units = $this->getSortedUnits($activatedProduct->unit);
        }
        return response()->json($data);
    }

    public function remove_to_cart():JsonResponse
    {
        $act_id = request('atc');
        AddToCart::where('id',$act_id)->update(['status'=>-1]);
        $data['sucses_alert'] = "The item has been successfully removed from your cart.";

        $data['atcs'] = AddToCart::with(['product', 'customer'])
            ->where('customer_id', user()->id)
            ->where('status',1)
            ->latest()
            ->get();

        $data['atcs'] = $data['atcs']->map(function ($atc) {
            $activatedProduct = $atc->product;
            if ($activatedProduct) {
                $activatedProduct = $this->transformProduct($activatedProduct, 45);
                $activatedProduct->units = $this->getSortedUnits($activatedProduct->unit);
            }
            return $atc;
        });

        $data['total_cart_item'] = $data['atcs']->sum(function ($atc) {
            return $atc->product ? 1 : 0;
        });

        return response()->json($data);
    }

    public function clearCart($uid):JsonResponse
    {
        $data['count'] = AddToCart::where('customer_id',decrypt($uid))->count();
        $data['alert'] = "The cart data has already been cleared";
        if($data['count']>0){
            AddToCart::where('customer_id',decrypt($uid))->update(['status'=>-1]);
            $data['alert'] = "The cart data has been cleared successfully";
        }

        return response()->json($data);
    }
    public function itemCheck($id):JsonResponse
    {
        $cartItem = AddToCart::findOrFail($id);
        if($cartItem->is_check == 1){
            $cartItem->is_check = 0;
        }else{
            $cartItem->is_check = 1;
        }
        $cartItem->update();
        $data['alert'] = "Item check status updated";



        return response()->json($data);
    }
    public function itemQuantity($id, $type):JsonResponse
    {

        $cartItem = AddToCart::findOrFail($id);
        if($type == 'plus'){
            $cartItem->quantity += 1;
        }else{
            $cartItem->quantity -= 1;
        }
        $cartItem->update();

        $data['alert'] = "Item quantity updated";
        return response()->json($data);
    }
    public function itemUnit($unit_id, $cart_id):JsonResponse
    {

        $cartItem = AddToCart::findOrFail($cart_id);
        $cartItem->unit_id = $unit_id;
        $cartItem->update();
        $data['alert'] = "Item unit updated";
        return response()->json($data);
    }

}
