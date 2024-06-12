<?php

namespace App\Http\Controllers\Admin\OrderByPrescription;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrescriptionOrderCreateRequest;
use App\Models\Medicine;
use App\Models\OrderPrescription;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Http\Traits\TransformProductTrait;
use App\Models\AddToCart;
use App\Models\Order;
use App\Http\Traits\TransformOrderItemTrait;

class OrderByPrescriptionController extends Controller
{
    use TransformProductTrait, TransformOrderItemTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }
    public function list($status): View
    {
        $data['status'] = $status;
        $status = $this->status($status);
        $data['statusBg'] = $this->statusBg($status);
        $data['ups'] = OrderPrescription::with(['customer', 'address'])->where('status', $status)->latest()->get();
        return view('admin.order_by_prescription.list', $data);
    }
    public function details($id): View
    {
        $id = decrypt($id);
        $data['up'] = OrderPrescription::with(['customer', 'address'])->findOrFail($id);
        $data['medicines'] = Medicine::activated()->orderBy('name', 'asc')->get();
        return view('admin.order_by_prescription.details', $data);
    }
    public function getUnit($id): JsonResponse
    {
        $medicine = Medicine::findOrFail($id);
        $data['units'] = $this->getSortedUnits($medicine->unit);
        return response()->json($data);
    }
    public function order_create(PrescriptionOrderCreateRequest $request, $up_id)
    {
        $up_id = decrypt($up_id);
        $up = OrderPrescription::findOrFail($up_id);
        $cart_ids = [];
        foreach ($request->item as $item) {
            $cart_item = new AddToCart();
            $cart_item->product_id = $item['medicine'];
            $cart_item->unit_id = $item['unit'];
            $cart_item->quantity = $item['quantity'];
            $cart_item->customer_id = $up->user_id;
            $cart_item->status = -1;
            $cart_item->creater()->associate(admin());
            $cart_item->save();
            array_push($cart_ids, $cart_item->id);
        }
        $order = new Order();
        $order->customer()->associate($up->customer);
        $order->address_id = $up->address_id;
        $order->status = 1;
        $order->order_id = generateOrderId();
        $order->delivery_type = $up->delivery_type;
        $order->delivery_fee = $up->delivery_fee;
        $order->obp_id = $up_id;
        $order->carts = json_encode($cart_ids);
        $order->creater()->associate(admin());
        $order->save();
        $up->update(['status' => 1]);
        flash()->addSuccess('Prescription Item Order Created Successfully.');
        return redirect()->route('obp.obp_list', 'pending');
    }

    public function orderDetails($order_id)
    {
        $id = decrypt($order_id);
        $data['order'] = Order::findOrFail($id);
        $data['order_items'] = $this->getOrderItems($data['order']);
        $data['totalRegularPrice'] = $this->calculateOrderTotalRegularPrice($data['order'], $data['order_items']);
        $data['totalDiscount'] = $this->calculateOrderTotalDiscount($data['order'], $data['order_items']);
        $data['subTotalPrice'] = $this->calculateOrderSubTotalPrice($data['order'], $data['order_items']);
        $data['totalPrice'] = $this->calculateOrderTotalPrice($data['order'], $data['order_items']);
        return view('admin.order_by_prescription.order_details', $data);
    }
    public function statusUpdate($status, $id)
    {
        $id = decrypt($id);
        $statusN = $this->status($status);
        OrderPrescription::findOrFail($id)->update(['status' => $statusN]);
        return redirect()->route('obp.obp_list', $status);
    }



    private function statusBg($status)
    {
        switch ($status) {
            case 0:
                return 'badge badge-info';
            case 1:
                return 'badge bg-success';
            case 2:
                return 'badge badge-danger';
        }
    }
    private function status($status)
    {
        switch ($status) {
            case 'pending':
                return 0;
            case 'ordered':
                return 1;
            case 'cancel':
                return 2;
        }
    }
}
