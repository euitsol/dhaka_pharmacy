<?php

namespace App\Http\Traits;

use App\Models\AddToCart;
use App\Http\Traits\TransformProductTrait;

trait TransformOrderItemTrait
{

    use TransformProductTrait;

    private function transformOrderItemPrice(&$order)
    {
        $order->products->each(function (&$product) {
            $this->setDiscountInformation($product);
            $product->totalPrice = $product->pivot->quantity * $product->pivot->unit->quantity * $product->price;
            $product->totalDiscountPrice = $product->pivot->quantity * $product->pivot->unit->quantity * $product->discounted_price;
        });
    }
    // private function OrderItemPrice($item_product)
    // {
    //     // return $item_product->quantity * $item_product->unit->quantity * $item_product->product->price;
    // }
    // private function OrderItemDiscountPrice($item_product)
    // {
    //     // $discounted_price = proDisPrice($item_product->product->price, $item_product->product->discounts);
    //     // return $item_product->quantity * $item_product->unit->quantity * $discounted_price;
    // }
    private function calculateOrderTotalPrice(&$order)
    {
        $this->transformOrderItemPrice($order);
        $order->totalPrice = $order->products->sum('totalPrice');
    }
    private function calculateOrderTotalDiscountPrice(&$order)
    {
        $this->transformOrderItemPrice($order);
        $order->totalDiscountPrice = $order->products->sum('totalDiscountPrice');
    }

    private function calculatePharmacyTotalAmount(&$od)
    {
        $this->calculateOrderTotalDiscountPrice($od->order);
        $discount = $od->odps->first()->pharmacy->pharmacyDiscounts->where('status', 1)->first() ? $od->odps->first()->pharmacy->pharmacyDiscounts->where('status', 1)->first()->discount_percent : 0;

        //add discounted product price to odp
        $od->odps->each(function (&$odp) use ($discount) {
            if ($odp->status == -1) return;
            $this->setDiscountInformation($odp->order_product->product);
            $price = $odp->order_product->quantity * $odp->order_product->unit->quantity * $odp->order_product->product->discounted_price;
            $odp->discounted_price = $price - ($price * ($discount / 100));
            $odp->selling_price = $price;
        });

        //add discounted total amount to od
        $od->totalPharmacyAmount = $od->odps->sum('discounted_price');
    }
}
