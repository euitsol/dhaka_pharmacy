<?php

namespace App\Http\Traits;

use App\Models\AddToCart;

trait TransformOrderItemTrait{

    private function getOrderItems($order)
    {
        $cart_items =  AddToCart::with([
            'product.pro_cat', 
            'product.pro_sub_cat', 
            'product.generic', 
            'product.company', 
            'product.strength', 
            'customer', 
            'unit',
            'product.discounts'
        ])
        ->whereIn('id', json_decode($order->carts))
        ->get()->map(function($cart_item){
            return $this->transformOrderItemPrice($cart_item);
        });
        return $cart_items;

    }
    private function transformOrderItemPrice($cart_item)
    {
        $cart_item->price = cartItemRegPrice($cart_item);
        $cart_item->discount_price = cartItemPrice($cart_item);
        $cart_item->discount = ($cart_item->price - $cart_item->discount_price);
        return $cart_item;
    }
    private function calculateOrderTotalRegularPrice($order, $order_items = false){
        if($order_items == false){
            $order_items = $this->getOrderItems($order);
        }
        return number_format(ceil($order_items->sum('price')));
    }
    private function calculateOrderTotalDiscount($order, $order_items = false){
        if($order_items == false){
            $order_items = $this->getOrderItems($order);
        }
        return number_format($order_items->sum('discount'),2);
    }
    private function calculateOrderSubTotalPrice($order, $order_items = false){
        if($order_items == false){
            $order_items = $this->getOrderItems($order);
        }
        return number_format(ceil($order_items->sum('discount_price')));
    }
    private function calculateOrderTotalPrice($order, $order_items = false){
        if($order_items == false){
            $order_items = $this->getOrderItems($order);
        }
        return number_format(ceil($order_items->sum('discount_price') + $order->delivery_fee));
    }
}
