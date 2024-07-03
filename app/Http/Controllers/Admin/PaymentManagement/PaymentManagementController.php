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
    public function __construct()
    {
        return $this->middleware('admin');
    }
    public function index($status): View
    {

        $data['payments'] = Payment::with('customer')->status($status)->latest()->get();
        $data['status'] = ucfirst($status);
        $data['statusBgColor'] = $this->getpaymentStatusBgColor($status);
        return view('admin.payment_management.index', $data);
    }
    public function details($id): View
    {
        $data['payment'] = Payment::with(['customer', 'order.products'])->findOrFail(decrypt($id));
        $data['payment_items'] = $data['payment']->order->products;

        $data['totalRegularPrice'] = $this->calculateOrderTotalRegularPrice($data['payment']->order);
        $data['totalDiscount'] = $this->calculateOrderTotalDiscount($data['payment']->order);
        $data['subTotalPrice'] = $this->calculateOrderSubTotalPrice($data['payment']->order);
        $data['totalPrice'] = $this->calculateOrderTotalPrice($data['payment']->order);

        return view('admin.payment_management.details', $data);
    }

    protected function getPaymentStatusBgColor($status)
    {
        $statusBgColor = ($status == 'success') ? 'badge badge-success' : (($status == 'pending') ? 'badge badge-info' : (($status == 'failed') ? 'badge badge-danger' : (($status == 'cancel') ? 'badge badge-warning' : 'badge badge-primary')));
        return $statusBgColor;
    }
}
