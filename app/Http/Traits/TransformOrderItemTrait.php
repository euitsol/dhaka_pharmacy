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
    private function OrderItemPrice($item_product)
    {
        return $item_product->quantity * $item_product->unit->quantity * $item_product->product->price;
    }
    private function OrderItemDiscountPrice($item_product)
    {
        $discounted_price = proDisPrice($item_product->product->price, $item_product->product->discounts);
        return $item_product->quantity * $item_product->unit->quantity * $discounted_price;
    }
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
}
