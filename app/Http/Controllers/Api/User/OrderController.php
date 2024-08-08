<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\API\Order\InitiatedRequest;
use App\Http\Requests\API\Order\IntSingleOrderRequest;
use App\Http\Requests\API\Order\OrderConfirmRequest;
use App\Models\AddToCart;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\JsonResponse;
use App\Http\Traits\TransformProductTrait;
use App\Http\Traits\TransformOrderItemTrait;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    use TransformProductTrait, TransformOrderItemTrait;
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

        foreach ($request->carts as $id) {
            $cart = AddToCart::currentCart()->whereId('id', $id)->first();

            if ($cart) {
                $op = new OrderProduct();
                $op->order_id = $order->id;
                $op->product_id = $cart->product_id;
                $op->unit_id = $cart->unit_id;
                $op->quantity = $cart->quantity;
                $op->save();

                $cart->forceDelete();
            }
        }
        return sendResponse(true, 'Order initiated successfully', ['order_id' => $order->id]);
    }

    public function int_single_order(IntSingleOrderRequest $request): JsonResponse
    {
        $user = $request->user();
        $orderId = generateOrderId();
        $order = new Order();

        $order->customer()->associate($user);
        $order->status = 0; //Order initiated
        $order->order_id = $orderId;
        $order->creater()->associate($user);
        $order->save();

        $op = new OrderProduct();
        $op->order_id = $order->id;
        $op->product_id = $request->product_id;
        $op->unit_id = $request->unit_id;
        $op->quantity = $request->quantity;
        $op->save();
        return sendResponse(true, 'Order initiated successfully', ['order_id' => $order->id]);
    }
    public function details(Request $request)
    {
        $user = $request->user();
        $order = Order::with([
            'products',
            'products.pro_cat',
            'products.generic',
            'products.pro_sub_cat',
            'products.company',
            'products.discounts',
            'products.units',
        ])->initiated()
            ->where('creater_type', get_class($user))
            ->where('creater_id', $user->id)
            ->where('id', $request->order_id)->first();
        if ($order) {
            $order->products->each(function (&$product) {
                $product = $this->transformProduct($product);
            });
            return sendResponse(true, 'Order details retrived successfully', ['order' => $order]);
        } else {
            return sendResponse(false, 'Something went wrong, please try again');
        }
    }

    public function order_confirm(OrderConfirmRequest $request)
    {
        $user = $request->user();
        $order = Order::with(['products'])
            ->where('creater_type', get_class($user))
            ->where('creater_id', $user->id)
            ->where('id', $request->order_id)->first();
        if ($order) {
            $order->address_id = $request->address;
            $order->status = 1; //Order Submit
            $order->delivery_type = $request->delivery_type;
            $order->delivery_fee = $request->delivery_fee;
            $order->save();
            $this->calculateOrderTotalDiscountPrice($order);

            $payment = new Payment();
            $payment->customer()->associate($user);
            $payment->payment_method = $request->payment_method;
            $payment->amount = $order->totalDiscountPrice + $order->delivery_fee;
            $payment->order_id = $order->id;
            $payment->status = 0; //Initialize
            $payment->creater()->associate($user);
            $payment->save();
            return sendResponse(true, 'Order confirm successfully', ['payment_id' => $payment->id]);
        } else {
            return sendResponse(false, 'Something went wrong, please try again');
        }
    }
}
