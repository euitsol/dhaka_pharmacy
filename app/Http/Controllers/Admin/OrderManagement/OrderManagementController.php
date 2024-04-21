<?php

namespace App\Http\Controllers\Admin\OrderManagement;

use App\Http\Controllers\Controller;
use App\Models\AddToCart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class OrderManagementController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('admin');
    }
    public function index($status): View
    {
        
        $data['orders'] = Order::with(['address','customer','ref_user'])->status($status)->latest()->get();
        $data['status'] = ucfirst($status);
        $data['statusBgColor'] = $this->getOrderStatusBgColor($status);
        return view('admin.order_management.index',$data);
    }
    public function details($id): View
    {
        $data['order'] = Order::findOrFail(decrypt($id));
        $data['payments'] = Payment::where('order_id',$id)->latest()->get();
        $data['order_items'] = [];
        foreach(json_decode($data['order']->carts) as $cart_id){
            $cart = AddToCart::with(['product.pro_cat','product.pro_sub_cat','product.generic','product.company','product.strength','customer','unit'])->where('id',$cart_id)->first();
            if($cart){
                array_push($data['order_items'], $cart);
            }
        }
        $paymentItemsCollection = collect($data['order_items']);
        $paymentItemsCollection->map(function($item) {
            $item->price = (($item->product->price*($item->unit->quantity ?? 1))*$item->quantity);
            $item->regular_price = (($item->product->regular_price*($item->unit->quantity ?? 1))*$item->quantity);
            $item->discount = (productDiscountAmount($item->product->id)*($item->unit->quantity ?? 1))*$item->quantity;
            return $item;
        });
        $data['totalPrice'] = $paymentItemsCollection->sum('price');
        $data['totalRegularPrice'] = $paymentItemsCollection->sum('regular_price');
        $data['totalDiscount'] = $paymentItemsCollection->sum('discount');
        return view('admin.order_management.details',$data);
    }
   
    protected function getOrderStatusBgColor($status){
        $statusBgColor = ($status == 'success') ? 'badge badge-success' : (($status == 'pending') ? 'badge badge-info' : (($status == 'failed') ? 'badge badge-danger' : (($status == 'cancel') ? 'badge badge-warning' : 'badge badge-primary')));
        return $statusBgColor;
    }


    
}
