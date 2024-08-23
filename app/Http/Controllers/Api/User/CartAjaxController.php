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
        $user = $request->user();
        if ($user) {
            $product = Medicine::activated()->where('slug', $request->product_slug)->first();
            if ($product) {
                $cart = AddToCart::where('product_id', $product->id)->where('customer_id', $user->id)->first();
                if ($cart) {
                    return sendResponse(false, 'This product is already in your cart!', null);
                } else {
                    $cart = new AddToCart();
                    $cart->product_id = $product->id;
                    $cart->customer_id = $user->id;
                    $cart->unit_id = $request->unit ?? null;
                    $cart->quantity = $request->quantity ?? 1;
                    $cart->save();
                }
                return sendResponse(true, $cart->product->name . ' has been added to your cart!');
            } else {
                return sendResponse(false, 'Oops! Something went wrong. Please try again.', null);
            }
        } else {
            return sendResponse(false, 'You need to log in to add items to your cart.', null);
        }
    }

    public function products(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user) {
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
            ])->where('customer_id', $user->id)->get();

            $products = $carts->each(function (&$cart) {
                $cart->product = $this->transformProduct($cart->product);
            });
            return sendResponse(true, 'Cart items retrived successfully', $products);
        } else {
            return sendResponse(false, 'You need to log in to get cart items.', null);
        }
    }

    public function update(CartUpdateRequest $request): JsonResponse
    {
        $user = $request->user();
        if ($user) {
            $atc = AddToCart::with([
                'product',
                'product.pro_cat',
                'product.generic',
                'product.pro_sub_cat',
                'product.company',
                'product.discounts',
                'product.units',
            ])->where('id', $request->cart_id)->first();
            if (!empty($atc)) {
                $atc->unit_id = $request->unit_id ? $request->unit_id : $atc->unit_id;
                $atc->quantity = $request->quantity ? $request->quantity : $atc->quantity;
                $atc->save();

                $atc->product = $this->transformProduct($atc->product);
                $atc->unit = $atc->unit;
                return sendResponse(true, ($request->unit_id ? 'Unit' : 'Quantity') . ' has been updated successfully!');
            }
        } else {
            return sendResponse(false, 'You need to log in to update item to your cart.', null);
        }
    }

    public function delete(CartDeleteRequest $request): JsonResponse
    {
        $user = $request->user();
        if ($user) {
            foreach ($request->carts as $cart) {
                AddToCart::where('id', $cart)->first()->forceDelete();
            }
            return sendResponse(true, 'Item has been deleted successfully!');
        } else {
            return sendResponse(false, 'You need to log in to delete item to your cart.', null);
        }
    }
}