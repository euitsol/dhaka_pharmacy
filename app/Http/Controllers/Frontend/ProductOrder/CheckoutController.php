<?php

namespace App\Http\Controllers\Frontend\ProductOrder;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Http\Requests\SingleOrderRequest;
use App\Models\Address;
use App\Models\AddToCart;
use App\Models\Medicine;
use App\Models\MedicineUnit;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use stdClass;
use App\Http\Traits\OrderNotificationTrait;

class CheckoutController extends BaseController
{
    use OrderNotificationTrait;

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
        return redirect()->route('product.int');
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
        // $order->customer_id = 1;//for test
        // $order->customer_type = "App\Models\User";//for test

        $order->carts = json_encode($atcs);
        $order->status = 0; //Order initiated
        $order->order_id = $orderId;
        $order->save();
        return redirect()->route('product.checkout',encrypt($order->id));
    }
    public function checkout($order_id){
        $customer_id = user()->id;
        $data['order_id'] = decrypt($order_id);
        $data['default_delivery_fee'] = 60;
        $atcs = AddToCart::check()->where('status',0)->where('customer_id', $customer_id)->latest()->get();
        foreach($atcs as $key=>$atc){
            $data['unit'] = MedicineUnit::findOrFail($atc->unit_id);

            $strength = $atc->product->strength ? ' (' . $atc->product->strength->quantity . ' ' . $atc->product->strength->unit . ')' : '';
            $atc->product->attr_title = Str::ucfirst(Str::lower($atc->product->name . $strength));
            $atc->product->name = Str::limit(Str::ucfirst(Str::lower($atc->product->name . $strength)), 45, '..');
            $atc->product->generic->name = Str::limit($atc->product->generic->name, 55, '..');
            $atc->product->company->name = Str::limit($atc->product->company->name, 55, '..');
            $atc->product->discount_amount = productDiscountAmount($atc->product->id);
            $atc->product->discount_percentage = productDiscountPercentage($atc->product->id);

            $data['checkItems'][$key]['product'] = $atc->product;
            $data['checkItems'][$key]['quantity'] = $atc->quantity;
            $data['checkItems'][$key]['name'] = $data['unit']->name;
            $data['checkItems'][$key]['unit'] = $atc->unit;
        }
        $data['customer'] = User::with(['address'])->findOrFail($customer_id);


        // dd($data);
        return view('frontend.product_order.checkout',$data);
    }
    public function order_success($order_id){
        $order = Order::findOrFail(decrypt($order_id));
        $data['order_id'] = $order->order_id;
        return view("frontend.product_order.order_success",$data);
    }
    public function order_failed($order_id){
        $order = Order::findOrFail(decrypt($order_id));
        $data['order_id'] = $order->order_id;
        return view("frontend.product_order.order_failed",$data);
    }
    public function order_cancel($order_id){
        $order = Order::findOrFail(decrypt($order_id));
        $data['order_id'] = $order->order_id;
        return view("frontend.product_order.order_cancel",$data);
    }

    public function order_confirm(Request $req, $order_id){
        $order = Order::findOrFail(decrypt($order_id));
        $order->address_id = $req->address_id;
        $order->status = 1; //Order Submit
        $order->payment_getway = $req->payment_mathod;
        $order->delivery_type = $req->delivery_type;
        $order->delivery_fee = $req->delivery_fee;
        $order->save();
        if($req->payment_method == 'ssl'){
            return redirect()->route('payment.index',$order_id);
        }else{
            flash()->addWarning('Payment gateway '.$req->payment_mathod.' not implement yet!');
            return redirect()->route('product.checkout',$order_id);
        }


    }

    public function address($id): JsonResponse
    {
        $data = Address::where('creater_id', user()->id)->where('creater_type', get_class(user()))->where('id', $id)->get()->first();
        return response()->json($data);
    }
}
