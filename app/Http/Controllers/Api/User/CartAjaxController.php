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
        $carts = AddToCart::with([
            'product',
            'product.pro_cat',
            'product.generic',
            'product.pro_sub_cat',
            'product.company',
            'product.discounts',
            'unit',
            'product.units' => function ($q) {
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
