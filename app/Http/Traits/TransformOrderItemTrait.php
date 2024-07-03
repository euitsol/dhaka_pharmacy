<?php

namespace App\Http\Traits;

use App\Models\AddToCart;

trait TransformOrderItemTrait
{

    private function transformOrderItemPrice($products)
    {
        $items = $products->each(function ($product) {
            $product->price = cartItemRegPrice($product);
            $product->discount_price = cartItemPrice($product);
            $product->discount = ($product->price - $product->discount_price);
            return $product;
        });
        return $items;
    }
    private function calculateOrderTotalRegularPrice($order)
    {
        $order_items = $this->transformOrderItemPrice($order->products);
        return number_format(ceil($order_items->sum('price')));
    }
    private function calculateOrderTotalDiscount($order)
    {
        $order_items = $this->transformOrderItemPrice($order->products);
        return number_format($order_items->sum('discount'), 2);
    }
    private function calculateOrderSubTotalPrice($order)
    {
        $order_items = $this->transformOrderItemPrice($order->products);
        return number_format(ceil($order_items->sum('discount_price')));
    }
    private function calculateOrderTotalPrice($order)
    {
        $order_items = $this->transformOrderItemPrice($order->products);
        return number_format(ceil($order_items->sum('discount_price') + $order->delivery_fee));
    }
}
