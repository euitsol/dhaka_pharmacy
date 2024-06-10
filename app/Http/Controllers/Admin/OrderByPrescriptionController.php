<?php

namespace App\Http\Controllers\Admin;

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
    public function list(): View
    {
        $data['ups'] = OrderPrescription::with(['customer', 'address'])->orderBy('status', 'asc')->get();
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
    public function order_create(PrescriptionOrderCreateRequest $request, $uid)
    {
        $uid = decrypt($uid);
        $aid = decrypt($request->aid);
        $delivery_type = decrypt($request->delivery_type);
        $up_id = decrypt($request->up_id);
        $cart_ids = [];
        foreach ($request->item as $item) {
            $cart_item = new AddToCart();
            $cart_item->product_id = $item['medicine'];
            $cart_item->unit_id = $item['unit'];
            $cart_item->quantity = $item['quantity'];
            $cart_item->customer_id = $uid;
            $cart_item->status = -1;
            $cart_item->creater()->associate(admin());
            $cart_item->save();
            array_push($cart_ids, $cart_item->id);
        }
        $order = new Order();
        $order->customer_id = $uid;
        $order->customer_type = 'App\Models\User';
        $order->address_id = $aid;
        $order->status = 1;
        $order->order_id = generateOrderId();
        $order->delivery_type = $delivery_type;
        $order->delivery_fee = 100;
        $order->carts = json_encode($cart_ids);
        $order->creater()->associate(admin());
        $order->save();
        OrderPrescription::findOrFail($up_id)->update(['status' => 1, 'order_id' => $order->id]);
        flash()->addSuccess('Prescription Item Order Created Successfully.');
        return redirect()->route('obp.obp_list');
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
}
