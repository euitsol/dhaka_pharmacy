<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AddToCartRequest;
use App\Http\Requests\Frontend\CartDeleteRequest;
use App\Http\Requests\Frontend\CartUpdateRequest;
use App\Http\Traits\TransformProductTrait;
use App\Models\AddToCart;
use App\Models\Medicine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class CartAjaxController extends Controller
{
    use TransformProductTrait;

    public function __construct()
    {
    }

    public function add(AddToCartRequest $request): JsonResponse
    {

        if (!auth()->guard('web')->check()) {
            return response()->json([
                'requiresLogin' => true,
                'message' => 'You need to log in to add items to your cart.',
            ]);
        }

        $customer_id = user()->id;

        $product = Medicine::activated()->where('slug', $request->slug)->first();
        if (!empty($product)) {
            $atc = new AddToCart();
            $atc->product_id = $product->id;
            $atc->customer_id = $customer_id;
            $atc->unit_id = $request->unit ?? null;
            $atc->quantity = $request->quantity ?? 1;
            $atc->save();

            return response()->json([
                'success' => true,
                'message' =>   $atc->product->name . ' has been added to your cart!',
            ]);
        }
    }

    public function products(): JsonResponse
    {
        if (!auth()->guard('web')->check()) {
            return response()->json([
                'requiresLogin' => true,
                'message' => 'You need to log in to add items to your cart.',
            ]);
        }

        $customer_id = user()->id;

        $atc = AddToCart::with([
            'product',
            'product.pro_cat',
            'product.generic',
            'product.pro_sub_cat',
            'product.company',
            'product.discounts',
            'unit',
            'product.units' => function ($q) {
                $q->orderBy('quantity', 'asc');
            },
        ])->currentCart()->get();

        $products = $atc->each(function (&$atc) {
            $atc->product = $this->transformProduct($atc->product);
        });
        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    public function update(CartUpdateRequest $request): JsonResponse
    {
        $atc = AddToCart::with([
            'product',
            'product.pro_cat',
            'product.generic',
            'product.pro_sub_cat',
            'product.company',
            'product.discounts',
            'unit',
            'product.units' => function ($q) {
                $q->orderBy('quantity', 'asc');
            },
        ])->where('id', $request->cart)->first();
        if (!empty($atc)) {
            $atc->unit_id = $request->unit ? $request->unit : $atc->unit_id;
            $atc->quantity = $request->quantity ? $request->quantity : $atc->quantity;
            $atc->save();

            $atc->load('unit');
            $atc->product = $this->transformProduct($atc->product);


            return response()->json([
                'success' => true,
                'data' => $atc,
                'message' => ($request->unit ? 'Unit' : 'Quantity') . ' has been updated successfully!',
            ]);
        }
    }

    public function delete(CartDeleteRequest $request): JsonResponse
    {
        foreach ($request->carts as $cart) {
            AddToCart::where('id', $cart)->first()->delete();
        }
        return response()->json([
            'success' => true,
            'message' => 'Item has been deleted successfully!',
        ]);
    }
}
