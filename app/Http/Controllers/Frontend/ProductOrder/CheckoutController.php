<?php

namespace App\Http\Controllers\Frontend\ProductOrder;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Models\AddToCart;
use App\Models\Medicine;
use App\Models\MedicineUnit;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use stdClass;

class CheckoutController extends BaseController
{
    public function checkout(){
        
        $data['delivery_fee'] = 60;


        if(request('product') !== null && request('unit') !== null){
            $product = Medicine::with(['strength','generic','company'])->where('slug',request('product'))->first();
            $data['unit'] = MedicineUnit::where('id',request('unit'))->first();
            if($product && $data['unit']){
                $strength = $product->strength ? ' (' . $product->strength->quantity . ' ' . $product->strength->unit . ')' : '';
                $product->attr_title = Str::ucfirst(Str::lower($product->name . $strength));
                $product->name = Str::limit(Str::ucfirst(Str::lower($product->name . $strength)), 45, '..');
                $product->generic->name = Str::limit($product->generic->name, 55, '..');
                $product->company->name = Str::limit($product->company->name, 55, '..');
                $product->discount = 2;

                
                $data['checkItems'][0]['product'] = $product;
                $data['checkItems'][0]['name'] = $data['unit']->name;
                $data['checkItems'][0]['quantity'] = $data['unit']->quantity;
                $data['checkItems'][0]['status'] = true;
            }else{
                flash()->addError('Invalid Product');
                return redirect()->back();
            }
        }
        else{
            $atcs = AddToCart::where('is_check',1)->latest()->get();
            foreach($atcs as $key=>$atc){
                $data['unit'] = MedicineUnit::findOrFail($atc->unit_id);

                $strength = $atc->product->strength ? ' (' . $atc->product->strength->quantity . ' ' . $atc->product->strength->unit . ')' : '';
                $atc->product->attr_title = Str::ucfirst(Str::lower($atc->product->name . $strength));
                $atc->product->name = Str::limit(Str::ucfirst(Str::lower($atc->product->name . $strength)), 45, '..');
                $atc->product->generic->name = Str::limit($atc->product->generic->name, 55, '..');
                $atc->product->company->name = Str::limit($atc->product->company->name, 55, '..');
                $atc->product->discount = 2;

                $data['checkItems'][$key]['product'] = $atc->product;
                $data['checkItems'][$key]['quantity'] = $atc->quantity;
                $data['checkItems'][$key]['name'] = $data['unit']->name;
            }
            
        }
        $paymentId = Str::random(10);
        $total_amount = array_reduce($data['checkItems'], function ($carry, $item) {
            $productPrice = $item['product']->price;
            $quantity = $item['quantity'];
            $productTotalPrice = $productPrice * $quantity;
            return $carry + $productTotalPrice;
        }, 0);
        $total_discount = array_reduce($data['checkItems'], function ($carry, $item) {
            $productDicount = $item['product']->discount;
            $quantity = $item['quantity'];
            $productTotalDiscount = $productDicount * $quantity;
            return $carry + $productTotalDiscount;
        }, 0);


        $products = array_map(function ($item) use ($data) {
            return [
                'product_id' => $item['product']->id,
                'unit_id' => $data['unit']->id,
                'quantity' => $item['quantity'],
            ];
        }, $data['checkItems']);

        $total_amount = ($total_amount+$data['delivery_fee'])-$total_discount;

        $order = new Order();
        $order->customer()->associate(admin());
        $order->products = json_encode($products);
        $order->status = 0; //Order initiated
        $order->payment_id = $paymentId;
        $order->total_amount = $total_amount;
        $order->total_discount = $total_discount;
        $order->delivery_fee = $data['delivery_fee'];
        $order->save();

        $data['order_id'] = $order->id;
        return view('frontend.product_order.checkout',$data);
    }

    public function order_confirm(Request $req, $order_id){
        dd(decrypt($order_id));
    }
}
