<?php

namespace App\Services;

use App\Models\{AddToCart, Order, Voucher, Address};
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Medicine;

class OrderService
{
    private $user;

    // Set the authenticated user
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function processOrder(array $data,  bool $isDirectOrder = false)
    {
        if (!$this->user) {
            throw new \Exception('User not found.');
        }

        return DB::transaction(function () use ($data, $isDirectOrder) {
            $carts = collect(); // Initialize an empty collection

            if ($isDirectOrder) {
                // Handle direct order
                $product = Medicine::with([
                    'units' => function ($query) {
                        $query->select('medicine_units.id', 'medicine_unit_bkdns.price');
                    },
                    'active_discounts',
                ])->where('slug',$data['product_slug'])->first();

                if (!$product) {
                    throw new ModelNotFoundException('Product not found.');
                }

                $unit = $product->units->find($data['unit_id']);
                if (!$unit) {
                    throw new ModelNotFoundException('Unit not found.');
                }

                $carts->push((object)[
                    'product' => $product,
                    'unit_id' => $data['unit_id'],
                    'quantity' => $data['quantity'],
                ]);

            } else {
                // Handle cart-based order (existing logic)
                $carts = AddToCart::with([
                    'product.units' => function ($query) {
                        $query->select('medicine_units.id', 'medicine_unit_bkdns.price');
                    },
                    'product.active_discounts',
                ])->whereIn('id', $data['carts'])
                    ->where('customer_id', $this->user->id)
                    ->get();
            }

            if ($carts->isEmpty()) {
                throw new ModelNotFoundException('No valid data found');
            }

            // Calculate order values
            $subTotal = $this->calculateSubTotal(carts: $carts);
            $voucherDiscount = $this->calculateVoucherDiscount($data['voucher_id'] ?? null, $subTotal);
            $deliveryFee = $this->calculateDeliveryFee($data['address_id'] ?? null);

            // Create order
            $order = Order::create([
                'order_id' => generateOrderId('api'),
                'customer_id' => $this->user->id,
                'customer_type' => get_class($this->user),
                'creater_id' => $this->user->id,
                'creater_type' => get_class($this->user),
                'address_id' => $data['address_id'] ?? null,
                'voucher_id' => $data['voucher_id'] ?? null,
                'sub_total' => $subTotal,
                'voucher_discount' => $voucherDiscount,
                'product_discount' => 0, //will be added later
                'delivery_fee' => $deliveryFee,
                'status' => 0
            ]);

            // Create order items and clear carts
            $this->createOrderItems($order, $carts);
            $this->clearCarts($carts->pluck('id')->toArray());

            return $order;
        });
    }

    public function getOrderDetails(string $orderId)
    {
        $order = Order::select(['id','order_id', 'customer_id', 'customer_type', 'address_id', 'voucher_id', 'sub_total', 'voucher_discount', 'product_discount', 'delivery_fee', 'status'])->with([
                    'customer:id,name,phone',
                    'products:id,name,slug,status,pro_cat_id,pro_sub_cat_id,company_id,generic_id,strength_id,dose_id,price,image',
                    'products.pro_cat:id,name,slug,status',
                    'products.generic:id,name,slug,status',
                    'products.pro_sub_cat:id,name,slug,status',
                    'products.company:id,name,slug,status',
                    'address:id,name,phone,city,street_address,latitude,longitude,apartment,floor,delivery_instruction,address',
                    'voucher'
                ])
            ->where('order_id', $orderId)
            ->first();

        if (!$order) {
            throw new ModelNotFoundException('Order not found.');
        }

        // Authorization check (only if $this->user is set)
        if ($this->user) {
            if (($order->customer_id !== $this->user->id) || ($order->customer_type !== get_class($this->user))) {
                throw new \Exception('Unauthorized access to this order.');
            }
        }

        return $order;
    }

    private function calculateSubTotal($carts)
    {
        return $carts->sum(function ($cart) {
            return $cart->quantity * $cart->product->units->find($cart->unit_id)->price;
        });
    }

    private function calculateVoucherDiscount(?int $voucherId, float $subTotal)
    {
        if (!$voucherId) return 0;

        $voucher = Voucher::valid()->findOrFail($voucherId);
        return $voucher->calculateDiscount($subTotal);
    }

    private function calculateDeliveryFee(?int $addressId)
    {
        if (!$addressId) return 0;
        $fee = 60;
        return $fee;
    }

    private function createOrderItems(Order $order, $carts)
    {
        $totalDiscount = 0;

        $orderItems = $carts->map(function ($cart) use (&$totalDiscount) {
            $product = $cart->product;
            $unitPrice = $product->units->find($cart->unit_id)->price;
            $quantity = $cart->quantity;

            // Fetch discount from discounts table
            $discount = $product->active_discounts()->where('unit_id', $cart->unit_id)->first();
            $productDiscount = 0;

            if ($discount) {
                if ($discount->discount_percentage) {
                    $productDiscount = ($unitPrice * $discount->discount_percentage) / 100;
                } elseif ($discount->discount_amount) {
                    $productDiscount = $discount->discount_amount;
                }
            }

            $totalDiscount += $productDiscount * $quantity;

            return [
                'product_id' => $product->id,
                'unit_id' => $cart->unit_id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'unit_discount' => $productDiscount,
                'status' => 1,
                'creater_id' => $this->user->id,
                'creater_type' => get_class($this->user),

            ];
        });

        // Attach products with discounts
        $order->products()->attach($orderItems);

        // Update order with total discount
        $order->update(['product_discount' => $totalDiscount]);

        return $order;
    }

    private function clearCarts(array $cartIds)
    {
        AddToCart::whereIn('id', $cartIds)->delete();
    }
}
