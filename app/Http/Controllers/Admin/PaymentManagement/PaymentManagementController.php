<?php

namespace App\Http\Controllers\Admin\PaymentManagement;

use App\Http\Controllers\Controller;
use App\Models\AddToCart;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class PaymentManagementController extends Controller
{
    public function __construct() {
        return $this->middleware('admin');
    }
    public function index($status): View
    {
        
        $data['payments'] = Payment::with(['customer','order'])->status($status)->latest()->get();
        $data['status'] = ucfirst($status);
        $data['statusBgColor'] = $this->getpaymentStatusBgColor($status);
        return view('admin.payment_management.index',$data);
    }
    public function details($id): View
    {
        $discount = 2;
        $data['payment'] = Payment::with(['customer','order'])->findOrFail($id);
        $data['payment_items'] = [];
        foreach(json_decode($data['payment']->order->carts) as $cart_id){
            $cart = AddToCart::with(['product.pro_cat','product.pro_sub_cat','product.generic','product.company','product.strength','customer','unit'])->findOrFail($cart_id);
            array_push($data['payment_items'], $cart);
        }
        $paymentItemsCollection = collect($data['payment_items']);
        $paymentItemsCollection->map(function($item) use($discount) {
            $item->price = $item->product->price-$discount;
            return $item;
        });
        $data['totalPrice'] = $paymentItemsCollection->sum('price');
       
        return view('admin.payment_management.details',$data);
    }
   
    protected function getPaymentStatusBgColor($status){
        $statusBgColor = ($status == 'success') ? 'badge badge-success' : (($status == 'pending') ? 'badge badge-info' : (($status == 'failed') ? 'badge badge-danger' : (($status == 'cancel') ? 'badge badge-warning' : 'badge badge-primary')));
        return $statusBgColor;
    }
}
