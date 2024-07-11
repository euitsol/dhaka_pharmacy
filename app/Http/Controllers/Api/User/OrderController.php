<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\API\Order\InitiatedRequest;
use App\Http\Traits\OrderTrait;
use App\Models\AddToCart;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class OrderController extends BaseController
{
    public function int_order(InitiatedRequest $request): JsonResponse
    {
        $user = $request->user();
        $orderId = generateOrderId();
        $order = new Order();

        $order->customer()->associate($user);
        $order->status = 0; //Order initiated
        $order->order_id = $orderId;
        $order->creater()->associate($user);
        $order->save();

        // if (isset($request->products) && !empty($request->products)) {   //for single orders & selected item checkout

        // } else { // for all cart item checkout

        // $carts = AddToCart::currentCart()->get();
        foreach (json_decode($request->cart_id, true) as $id) {
            $cart = AddToCart::currentCart()->whereId('id', $id)->first();

            if ($cart) {
                $op = new OrderProduct();
                $op->order_id = $order->id;
                $op->product_id = $cart->product_id;
                $op->unit_id = $cart->unit_id;
                $op->quantity = $cart->quantity;
                $op->save();

                $cart->status = -1;
                $cart->update();
            }
        }
        // }
        return sendResponse(true, 'Order initiated successfully', $order->id);
    }
}
