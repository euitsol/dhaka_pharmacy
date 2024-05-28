<?php

namespace App\Http\Traits;

use App\Models\AddToCart;
use App\Models\MedicineUnit;
use Illuminate\Support\Str;

trait ProductQueryTrait{

    private function getCartItems($cart_id_object)
    {
        return AddToCart::with([
            'product.pro_cat', 
            'product.pro_sub_cat', 
            'product.generic', 
            'product.company', 
            'product.strength', 
            'customer', 
            'unit'
        ])
        ->whereIn('id', json_decode($cart_id_object))
        ->get()
        ->map(function($cart_item) {
            return $this->transformProduct($cart_item);
        });
    }

    private function transformOrderItem($cart_item)
    {
            $cart_item->price = ($cart_item->product->price * ($cart_item->unit->quantity ?? 1)) * $cart_item->quantity;
            $cart_item->discount_price = ($cart_item->product->discountPrice() * ($cart_item->unit->quantity ?? 1)) * $cart_item->quantity;
            $cart_item->discount = productDiscountAmount($cart_item->product->id) * ($cart_item->unit->quantity ?? 1) * $cart_item->quantity;
    
            // Assigning transformed product values to the cart item
            $cart_item->product = $this->transformProduct($cart_item->product);
    
            return $cart_item;
    }
    
    private function transformProduct($product)
    {
        $product->image = storage_url($product->image);
        $strength = $product->strength ? ' (' . $product->strength->quantity . ' ' . $product->strength->unit . ')' : '';
        $product->attr_title = Str::ucfirst(Str::lower($product->name . $strength));
        $product->name = Str::limit(Str::ucfirst(Str::lower($product->name . $strength)), 30, '..');
        $product->generic->name = Str::limit($product->generic->name, 30, '..');
        $product->company->name = Str::limit($product->company->name, 30, '..');
        $product->discount_amount = productDiscountAmount($product->id);
        $product->discount_percentage = productDiscountPercentage($product->id);
    
        return $product;
    }

    private function calculateOrderPrices($order)
    {
        $order->totalPrice = number_format(ceil($order->order_items->sum('discount_price') + $order->delivery_fee));
        $order->totalRegularPrice = number_format(ceil($order->order_items->sum('price') + $order->delivery_fee));
        $order->totalDiscount = $order->order_items->sum('discount');
        return $order;
    }

    private function getSortedUnits($unitJson)
    {
        $unitIds = (array) json_decode($unitJson, true);
        $units = MedicineUnit::whereIn('id', $unitIds)->get()->sortBy('quantity')->values()->all();
        return $units;
    }
}
