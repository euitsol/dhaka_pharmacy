<?php

namespace App\Http\Controllers\Admin\PaymentManagement;

use App\Http\Controllers\Controller;
use App\Models\AddToCart;
use App\Models\Payment;
use Illuminate\View\View;
use App\Http\Traits\TransformOrderItemTrait;


class PaymentManagementController extends Controller
{
    use TransformOrderItemTrait;
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
        $data['payment_items'] = $this->getOrderItems($data['payment']->order);
    
        $data['totalRegularPrice'] = $this->calculateOrderTotalRegularPrice($data['payment']->order, $data['payment_items']);
        $data['totalDiscount'] = $this->calculateOrderTotalDiscount($data['payment']->order, $data['payment_items']);
        $data['subTotalPrice'] = $this->calculateOrderSubTotalPrice($data['payment']->order, $data['payment_items']);
        $data['totalPrice'] = $this->calculateOrderTotalPrice($data['payment']->order, $data['payment_items']);
       
        return view('admin.payment_management.details',$data);
    }
   
    protected function getPaymentStatusBgColor($status){
        $statusBgColor = ($status == 'success') ? 'badge badge-success' : (($status == 'pending') ? 'badge badge-info' : (($status == 'failed') ? 'badge badge-danger' : (($status == 'cancel') ? 'badge badge-warning' : 'badge badge-primary')));
        return $statusBgColor;
    }
}
