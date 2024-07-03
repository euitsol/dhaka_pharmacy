<?php

namespace App\Http\Traits;

use App\Models\AddToCart;
use App\Http\Traits\TransformProductTrait;

trait TransformOrderItemTrait
{

    use TransformProductTrait;

    private function transformOrderItemPrice(&$order)
    {
        $order->products->each(function ($product) {
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
        $this->setDiscountInformation($item_product->product);
        return $item_product->quantity * $item_product->unit->quantity * $item_product->product->discounted_price;
    }
    // private function calculateOrderTotalRegularPrice($order)
    // {
    //     $order_items = $this->transformOrderItemPrice($order->products);
    //     return number_format(ceil($order_items->sum('price')));
    // }
    // private function calculateOrderTotalDiscount($order)
    // {
    //     $order->products->each(function ($product) {
    //         $this->setDiscountInformation($product);
    //         $product->DiscountAmount = $product->pivot->quantity * $product->pivot->unit->quantity * $product->discounted_amount;
    //     });
    //     $order->totalDiscount = $order->products->sum('DiscountAmount');
    // }
    // private function calculateOrderSubTotalPrice(&$order)
    // {
    //     $order->products->each(function ($product) {
    //         $this->setDiscountInformation($product);
    //         $product->totalDiscountedPrice = $product->pivot->quantity * $product->pivot->unit->quantity * $product->discounted_price;
    //     });
    //     $order->subTotalPrice = $order->products->sum('totalDiscountedPrice');
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
}
