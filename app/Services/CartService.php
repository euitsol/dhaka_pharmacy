<?php

namespace App\Services;

use App\Models\{AddToCart, Order, Voucher, Address, Medicine, Payment, User};
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Services\{OrderTimelineService, VoucherService, AddressService, PaymentService};
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use App\Services\ProductService;

class CartService
{
    private Authenticatable $user;
    private AddToCart $cart;
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    // Set the authenticated user
    public function setUser(Authenticatable $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function setCart(AddToCart|int $cart): self
    {
        if (!$cart instanceof AddToCart) {
            $cart = AddToCart::find($cart);
        }
        $this->cart = $cart;
        return $this;
    }

    public function addItem(Medicine $item, array $data): AddToCart
    {
        $atc = AddToCart::create([
            'customer_id' => $this->user->id,
            'product_id' => $item->id,
            'unit_id' => $data['unit'] ?? $this->getDefaultUnit($item),
            'quantity' => $data['quantity'] ?? null,
            'status' => 1,
            'creater_id' => $this->user->id,
            'creater_type' => get_class($this->user),
        ]);

        return $atc;
    }

    public function currentCart(): array
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
                $q->orderBy('price', 'asc');
            },
        ])->currentCart($this->user)->get()->each(function (&$cart) {
            $cart->product = $this->productService->modifyProduct($cart->product);
            $this->assignSelectedUnit($cart);
        });

        $totalPrice = $this->calculateTotalPrice($carts);

        return [
            'carts'      => $carts,
            'total_discounted_price'=> $totalPrice,
        ];
    }


    public function updateCart(array $data): AddToCart
    {
        $attributes = [];

        if (!empty($data['unit_id']) && $data['unit_id'] != null) {
            $attributes['unit_id'] = $data['unit_id'];
        }

        if (!empty($data['quantity']) && $data['quantity'] != null) {
            $attributes['quantity'] = $data['quantity'];
        }

        $this->cart->update($attributes);
        return $this->cart;
    }

    public function removeItem(): AddToCart
    {
        $this->cart->delete();
        return $this->cart;
    }

    protected function getDefaultUnit(Medicine $product): ?int
    {
        if ($product->units->isEmpty()) {
            return null;
        }
        return $product->units()->orderBy('price', 'asc')->first()->id;
    }

    protected function assignSelectedUnit(AddToCart $cart): AddToCart
    {
        $selectedUnit = $cart->product->units()->find($cart->unit_id);

        if ($selectedUnit) {
            $cart->selected_unit = $selectedUnit->only(['id', 'name', 'slug', 'image_url']) + [
                'price' => $selectedUnit->pivot->price,
                'discounted_price' => proDisPrice($selectedUnit->pivot->price, $cart->product->discounts),
            ];
        } else {
            $cart->selected_unit = null;
            Log::error(message: "Selected unit not found for cart item ID: {$cart->id}, unit_id: {$cart->unit_id}, product_id: {$cart->product_id}");
        }
        return $cart;
    }

    protected function calculateTotalPrice(Collection $carts): float
    {
        return $carts->sum(function ($cart) {
            $unitPrice = $cart->selected_unit['discounted_price'];
            return $cart->quantity * $unitPrice;
        });
    }

    protected function validateUnit(Medicine $product, int $unit): void
    {
        if (!$product->units()->where('medicine_units.id', $unit)->exists()) {
            throw new Exception('The selected unit is not associated with the medicine.');
        }

    }

}
