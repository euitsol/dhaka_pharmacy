<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\SingleOrderRequest;
use App\Models\Address;
use App\Models\AddToCart;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Traits\OrderNotificationTrait;
use App\Http\Traits\TransformProductTrait;

class CheckoutController extends Controller
{
    use OrderNotificationTrait, TransformProductTrait;
    public function single_order(SingleOrderRequest $req){
        $product = Medicine::activated()->where('slug',$req->slug)->first();
        $customer_id = user()->id;

        $atc = new AddToCart();
        $atc->product_id = $product->id;
        $atc->customer_id = $customer_id;
        $atc->unit_id = $req->unit_id;
        $atc->quantity = 1;
        $atc->status = 3;
        $atc->save();
        return redirect()->route('u.ck.product.int');
    }

    public function int_order($m = false){
        $customer_id = user()->id;

        $status = AddToCart::where('customer_id', $customer_id)->where('status', 0);
        $status->update(['status' => -1]);

        if($m){
            $m_status = AddToCart::where('customer_id', $customer_id)->where('status', 1);
            $m_status->update(['status' => 0]);
        }else{
            $change_cart_status = AddToCart::where('customer_id', $customer_id)->where('status', 3);
            $change_cart_status->update(['status' => 0]);
        }

        $atcs = AddToCart::check()->where('status',0)->where('customer_id',$customer_id)->pluck('id')->toArray();
        $orderId = generateOrderId();
        $order = new Order();

        $order->customer()->associate(user());
        $order->carts = json_encode($atcs);
        $order->status = 0; //Order initiated
        $order->order_id = $orderId;
        $order->save();
        return redirect()->route('u.ck.product.checkout',encrypt($order->id));
    }
    public function checkout($order_id){
        $customer_id = user()->id;
        $data['order_id'] = decrypt($order_id);
        $data['default_delivery_fee'] = 60;
        $atcs = AddToCart::with(['product.pro_cat','product.generic','product.pro_sub_cat','product.company','product.discounts','unit'])->check()->where('status',0)->where('customer_id', $customer_id)->latest()->get();
        foreach($atcs as $key=>$atc){
            $data['unit'] = $atc->unit;
            $atc->product = $this->transformProduct($atc->product, 45);
            $data['checkItems'][$key]['product'] = $atc->product;
            $data['checkItems'][$key]['quantity'] = $atc->quantity;
            $data['checkItems'][$key]['name'] = $data['unit']->name;
            $data['checkItems'][$key]['unit'] = $atc->unit;
        }
        $data['customer'] = User::with(['address'])->findOrFail($customer_id);
        return view('user.product_order.checkout',$data);
    }
    public function order_success($order_id){
        $order = Order::findOrFail(decrypt($order_id));
        $data['order_id'] = $order->order_id;
        return view("user.product_order.order_success",$data);
    }
    public function order_failed($order_id){
        $order = Order::findOrFail(decrypt($order_id));
        $data['order_id'] = $order->order_id;
        return view("user.product_order.order_failed",$data);
    }
    public function order_cancel($order_id){
        $order = Order::findOrFail(decrypt($order_id));
        $data['order_id'] = $order->order_id;
        return view("user.product_order.order_cancel",$data);
    }

    public function order_confirm(Request $req, $order_id){
        $order = Order::findOrFail(decrypt($order_id));
        $order->address_id = 1;
        $order->status = 1; //Order Submit
        $order->payment_getway = $req->payment_mathod;
        $order->delivery_type = $req->delivery_type;
        $order->delivery_fee = $req->delivery_fee;
        $order->save();
        if($req->payment_method == 'ssl'){
            return redirect()->route('u.payment.index',$order_id);
        }else{
            flash()->addWarning('Payment gateway '.$req->payment_mathod.' not implement yet!');
            return redirect()->route('u.ck.product.checkout',$order_id);
        }


    }

    public function address($id): JsonResponse
    {
        $data = Address::where('creater_id', user()->id)->where('creater_type', get_class(user()))->where('id', $id)->get()->first();
        return response()->json($data);
    }
}