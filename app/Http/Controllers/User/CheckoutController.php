<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\SingleOrderRequest;
use App\Http\Requests\User\OrderConfirmRequest;
use App\Http\Requests\User\OrderIntRequest;
use App\Http\Traits\DeliveryTrait;
use App\Http\Traits\OrderTrait;
use App\Models\Address;
use App\Models\AddToCart;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Traits\OrderNotificationTrait;
use App\Http\Traits\TransformProductTrait;
use App\Http\Traits\TransformOrderItemTrait;
use App\Models\Payment;

class CheckoutController extends Controller
{
    use OrderNotificationTrait, TransformProductTrait, OrderTrait, TransformOrderItemTrait, DeliveryTrait;

    public function int_order(OrderIntRequest $request)
    {
        $order = $this->createOrder();

        if (isset($request->product)) { // for single order int
            $op = new OrderProduct();
            $op->order_id = $order->id;
            $op->product_id = $request->product;
            $op->unit_id = $request->unit_id;
            $op->quantity = $request->quantity;
            $op->save();
        } else { // for multiple order int

            $carts = AddToCart::currentCart()->get();
            foreach ($carts as $cart) {
                $op = new OrderProduct();
                $op->order_id = $order->id;
                $op->product_id = $cart->product_id;
                $op->unit_id = $cart->unit_id;
                $op->quantity = $cart->quantity;
                $op->save();
                $cart->forceDelete();
            }
        }

        return redirect()->route('u.ck.index', encrypt($order->id));
    }

    public function checkout($order_id)
    {
        $data['order'] = Order::with([
            'products',
            'products.pro_cat',
            'products.generic',
            'products.pro_sub_cat',
            'products.company',
            'products.discounts',
            'products.units',
        ])->initiated()->self()->findOrFail(decrypt($order_id));
        $data['order']->products->each(function (&$product) {
            $product = $this->transformProduct($product);
        });
        $data['customer'] = User::with(['address'])->findOrFail(user()->id);
        $data['customer']->address->each(function (&$address) {
            $address->delivery_charge = $this->getDeliveryCharge($address->latitude, $address->longitude);
        });
        return view('user.product_order.checkout', $data);
    }
    public function order_confirm(OrderConfirmRequest $req, $order_id)
    {
        $address =  Address::where('creater_id', user()->id)->where('creater_type', get_class(user()))->where('id', $req->address)->first();
        $order = Order::with(['products', 'address'])->self()->findOrFail(decrypt($order_id));
        $order->address_id = $req->address;
        $order->status = 1; //Order Submit
        $order->delivery_type = 0;
        $order->delivery_fee = $this->getDeliveryCharge($address->latitude, $address->longitude);
        $order->save();
        $this->calculateOrderTotalDiscountPrice($order);

        $payment = new Payment();
        $payment->customer()->associate(user());
        $payment->payment_method = $req->payment_method;
        $payment->amount = $order->totalDiscountPrice + $order->delivery_fee;
        $payment->order_id = $order->id;
        $payment->status = 0; //Initialize
        $payment->creater()->associate(user());
        $payment->save();

        return redirect()->route('u.payment.int', encrypt($payment->id));
    }
    public function address($id): JsonResponse
    {
        $data = Address::where('creater_id', user()->id)->where('creater_type', get_class(user()))->where('id', $id)->get()->first();
        return response()->json($data);
    }
}