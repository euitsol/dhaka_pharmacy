<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AddToCartRequest;
use App\Http\Requests\Frontend\CartDeleteRequest;
use App\Http\Requests\Frontend\CartUpdateRequest;
use App\Http\Traits\TransformProductTrait;
use App\Models\AddToCart;
use App\Models\Medicine;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use SebastianBergmann\Type\VoidType;
use App\Services\CartService;
use Exception;

class CartAjaxController extends Controller
{
    use TransformProductTrait;

    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function add(AddToCartRequest $request): JsonResponse|VoidType
    {
        $user = user();
        $product = Medicine::activated()->where('slug', $request->slug)->first();

        try {
            $atc = $this->cartService->setUser($user)
            ->addItem($product, $request->validated());
            return response()->json([
                'success' => true,
                'message' =>   $atc->product->name . ' has been added to your cart!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function products(): JsonResponse
    {
        $user = user();

        try {
            $this->cartService->setUser($user);
            $items = $this->cartService->currentCart();

            return response()->json([
                'success' => true,
                'data' => $items,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function update(CartUpdateRequest $request): JsonResponse
    {
        $user = user();
        try {
            $this->cartService->setUser($user);
            $atc = $this->cartService->setCart($request->cart_id)->updateCart($request->all());
            return response()->json([
                'success' => true,
                'data' => $atc,
                'message' => ($request->unit_id ? 'Unit' : 'Quantity') . ' has been updated successfully!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
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
