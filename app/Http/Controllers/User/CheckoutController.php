<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\SingleOrderRequest;
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

class CheckoutController extends Controller
{
    use OrderNotificationTrait, TransformProductTrait, OrderTrait;

    public function a_checkout(Request $request): RedirectResponse
    {
        $order = $this->createOrder();

        if(isset($request->products) && !empty($request->products)){   //for single orders & selected item checkout

        }else{ // for all cart item checkout

            $carts = AddToCart::currentCart()->get();
            foreach($carts as $cart){
                $cart->status = -1;
                $cart->update();

                $op = new OrderProduct();
                $op->order_id = $order->id;
                $op->product_id = $cart->product_id;
                $op->unit_id = $cart->unit_id;
                $op->quantity = $cart->quantity;
                $op->save();
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
                                        'products.units'
                                        ])->initiated()->self()->findOrFail(decrypt($order_id));
        $data['order']->products->each(function (&$product) {
            $product = $this->transformProduct($product);
        });
        $data['customer'] = User::with(['address'])->findOrFail(user()->id);
        return view('user.product_order.checkout', $data);
    }

    public function order_success($order_id)
    {
        $order = Order::findOrFail(decrypt($order_id));
        $data['order_id'] = $order->order_id;
        return view("user.product_order.order_success", $data);
    }
    public function order_failed($order_id)
    {
        $order = Order::findOrFail(decrypt($order_id));
        $data['order_id'] = $order->order_id;
        return view("user.product_order.order_failed", $data);
    }
    public function order_cancel($order_id)
    {
        $order = Order::findOrFail(decrypt($order_id));
        $data['order_id'] = $order->order_id;
        return view("user.product_order.order_cancel", $data);
    }

    public function order_confirm(Request $req, $order_id)
    {
        $order = Order::findOrFail(decrypt($order_id));
        $order->address_id = $req->address_id;
        $order->status = 1; //Order Submit
        $order->payment_getway = $req->payment_mathod;
        $order->delivery_type = $req->delivery_type;
        $order->delivery_fee = $req->delivery_fee;
        $order->save();
        if ($req->payment_method == 'ssl') {
            return redirect()->route('u.payment.index', $order_id);
        } else {
            flash()->addWarning('Payment gateway ' . $req->payment_mathod . ' not implement yet!');
            return redirect()->route('u.ck.product.checkout', $order_id);
        }
    }

    public function address($id): JsonResponse
    {
        $data = Address::where('creater_id', user()->id)->where('creater_type', get_class(user()))->where('id', $id)->get()->first();
        return response()->json($data);
    }
}
