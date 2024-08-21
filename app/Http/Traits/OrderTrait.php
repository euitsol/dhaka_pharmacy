<?php

namespace App\Http\Traits;

use App\Models\Order;
use Illuminate\Support\Facades\Log;


trait OrderTrait
{
    use LocationDistanceCalculateTrait;

    public function  createOrder()
    {
        $this->updateUserDeliveryFee();
        $orderId = generateOrderId();
        $order = new Order();

        $order->customer()->associate(user());
        $order->status = 0; //Order initiated
        $order->order_id = $orderId;
        $order->creater()->associate(user());
        $order->save();

        return $order;
    }
}