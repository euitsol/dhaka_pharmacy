<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\API\Frontend\AddToCartRequest;
use App\Http\Requests\API\Frontend\CartDeleteRequest;
use App\Http\Requests\API\Frontend\CartUpdateRequest;
use App\Models\AddToCart;
use App\Models\Medicine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Traits\TransformProductTrait;

class CartAjaxController extends BaseController
{
    use TransformProductTrait;
    public function add(AddToCartRequest $request): JsonResponse
    {
            $product = Medicine::activated()->where('slug', $request->product_slug)->first();
            $cart = new AddToCart();
            $cart->product_id = $product->id;
            $cart->customer_id = auth()->user()->id;
            $cart->unit_id = $request->unit_id ?? null;
            $cart->quantity = $request->quantity ?? 1;
            $cart->save();
            return sendResponse(true, $cart->product->name . ' has been added to your cart!');
    }

    public function products(Request $request): JsonResponse
    {
        $carts = AddToCart::select('id','product_id','customer_id','unit_id','quantity', 'is_check', 'status')
        ->with([
            'product:id,name,image,slug,status,pro_cat_id,pro_sub_cat_id,company_id,generic_id,strength_id,dose_id,price,description,image,prescription_required,kyc_required,max_quantity,created_at,status,is_best_selling',
            'product.pro_cat:id,name,slug,status',
            'product.generic:id,name,slug,status',
            'product.pro_sub_cat:id,name,slug,status',
            'product.company:id,name,slug,status',
            'product.discounts:id,pro_id,unit_id,discount_amount,discount_percentage,status',
            'unit:id,name,quantity',
            'product.strength:id,name,status',
            'product.dosage:id,name,slug,status',
            'product.units' => function ($q) {
                $q->select('medicine_units.id', 'medicine_units.name', 'medicine_units.quantity', 'medicine_units.image', 'medicine_units.status');
                $q->orderBy('quantity', 'asc');
            }
        ])->where('customer_id', auth()->user()->id)->get();

        $products = $carts->each(function (&$cart) {
            $cart->product = $this->transformProduct($cart->product);
        });

        return sendResponse(true, 'Cart items retrived successfully', $products);
    }

    public function update(CartUpdateRequest $request): JsonResponse
    {
        $atc = AddToCart::where('id', $request->cart_id)->first();

        $atc->unit_id = $request->unit_id ?? $atc->unit_id;
        $atc->quantity = $request->quantity ?? $atc->quantity;
        $atc->save();

       return sendResponse(true, ($request->unit_id ? 'Unit' : 'Quantity') . ' has been updated successfully!');
    }

    public function delete(CartDeleteRequest $request): JsonResponse
    {
        foreach ($request->carts as $cart) {
            AddToCart::where('id', $cart)->first()->forceDelete();
        }
        return sendResponse(true, 'Item has been deleted successfully!');

    }
}
