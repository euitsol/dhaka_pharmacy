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
        
        $data['payments'] = Payment::with('customer')->status($status)->latest()->get();
        $data['status'] = ucfirst($status);
        $data['statusBgColor'] = $this->getpaymentStatusBgColor($status);
        return view('admin.payment_management.index',$data);
    }
    public function details($id): View
    {
        $data['payment'] = Payment::with(['customer','order'])->findOrFail(decrypt($id));
        $data['payment_items'] = AddToCart::with(['product.pro_cat', 'product.pro_sub_cat', 'product.generic', 'product.company', 'product.strength', 'customer', 'unit'])
                            ->whereIn('id', json_decode($data['payment']->order->carts))
                            ->get();
        
        $data['payment_items']->transform(function($item) {
            $item->price = (($item->product->price*($item->unit->quantity ?? 1))*$item->quantity);
            $item->discount_price = (($item->product->discountPrice()*($item->unit->quantity ?? 1))*$item->quantity);
            $item->discount = (productDiscountAmount($item->product->id)*($item->unit->quantity ?? 1))*$item->quantity;
            return $item;
        });
        $data['totalPrice'] = $data['payment_items']->sum('discount_price');
        $data['totalRegularPrice'] = $data['payment_items']->sum('price');
        $data['totalDiscount'] = $data['payment_items']->sum('discount');
       
        return view('admin.payment_management.details',$data);
    }
   
    protected function getPaymentStatusBgColor($status){
        $statusBgColor = ($status == 'success') ? 'badge badge-success' : (($status == 'pending') ? 'badge badge-info' : (($status == 'failed') ? 'badge badge-danger' : (($status == 'cancel') ? 'badge badge-warning' : 'badge badge-primary')));
        return $statusBgColor;
    }
}
