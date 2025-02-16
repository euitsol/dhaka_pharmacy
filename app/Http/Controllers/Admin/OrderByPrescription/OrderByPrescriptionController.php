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
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Services\PrescriptionService;
use Exception;
use Illuminate\Http\RedirectResponse;

class OrderByPrescriptionController extends Controller
{
    use TransformProductTrait, TransformOrderItemTrait;

    protected PrescriptionService $prescriptionService;
    public function __construct(PrescriptionService $prescriptionService)
    {
        $this->middleware('admin');
        $this->prescriptionService = $prescriptionService;
    }
    public function list($status): View|RedirectResponse
    {
        try {
            $data['order_prescriptions'] = $this->prescriptionService->getOrderPrescriptions($this->prescriptionService->resolveStatus($status));
            $data['status'] = $status;
            return view('admin.order_by_prescription.list', $data);
        } catch (Exception $e) {
            flash()->addError($e->getMessage());
            return redirect()->back();
        }
    }
    public function details($id): View|RedirectResponse
    {
        $id = decrypt($id);
        try{
            $prescription = $this->prescriptionService->setOrderPrescription($id);
            $data['details'] = $prescription->getOrderPrescriptionsDetails();
            // dd($data['details']->toArray());
        }
        catch(Exception $e){
            flash()->addError($e->getMessage());
            return redirect()->back();
        }
        return view('admin.order_by_prescription.details', $data);
    }
    public function getUnit($id): JsonResponse
    {
        $medicine = Medicine::with(['units' => function ($q) {
            $q->orderBy('quantity', 'asc');
        }])->findOrFail($id);
        $data['units'] = $medicine->units;
        return response()->json($data);
    }
    public function order_create(PrescriptionOrderCreateRequest $request, $up_id)
    {
        $up_id = decrypt($up_id);
        $up = OrderPrescription::findOrFail($up_id);
        // $cart_ids = [];
        // foreach ($request->item as $item) {
        //     $cart_item = new AddToCart();
        //     $cart_item->product_id = $item['medicine'];
        //     $cart_item->unit_id = $item['unit'];
        //     $cart_item->quantity = $item['quantity'];
        //     $cart_item->customer_id = $up->user_id;
        //     $cart_item->status = -1;
        //     $cart_item->creater()->associate(admin());
        //     $cart_item->save();
        //     array_push($cart_ids, $cart_item->id);
        // }
        $order = new Order();
        $order->customer()->associate($up->customer);
        $order->address_id = $up->address_id;
        $order->status = 1;
        $order->order_id = generateOrderId();
        $order->delivery_type = $up->delivery_type;
        $order->delivery_fee = $up->delivery_fee;
        $order->obp_id = $up_id;
        // $order->carts = json_encode($cart_ids);
        $order->creater()->associate(admin());
        $order->save();
        foreach ($request->item as $item) {
            $op = new OrderProduct();
            $op->order_id = $order->id;
            $op->product_id = $item['medicine'];
            $op->unit_id = $item['unit'];
            $op->quantity = $item['quantity'];
            $op->save();
        }
        $up->update(['status' => 1]);
        flash()->addSuccess('Prescription Item Order Created Successfully.');
        return redirect()->route('obp.obp_list', 'ordered');
    }

    public function orderDetails($order_id)
    {
        $id = decrypt($order_id);
        $data['order'] = Order::with('products')->findOrFail($id);
        $this->calculateOrderTotalPrice($data['order']);
        $this->calculateOrderTotalDiscountPrice($data['order']);

        // $data['order_items'] = $data['order']->products;
        // $data['totalRegularPrice'] = $this->calculateOrderTotalRegularPrice($data['order']);
        // $data['totalDiscount'] = $this->calculateOrderTotalDiscount($data['order']);
        // $data['subTotalPrice'] = $this->calculateOrderSubTotalPrice($data['order']);
        // $data['totalPrice'] = $this->calculateOrderTotalPrice($data['order']);
        return view('admin.order_by_prescription.order_details', $data);
    }
    public function statusUpdate($status, $id)
    {
        $id = decrypt($id);
        $statusN = $this->status($status);
        OrderPrescription::findOrFail($id)->update(['status' => $statusN]);
        return redirect()->route('obp.obp_list', $status);
    }


    public function getSelectMedicine(Request $request)
    {
        $param = $request->input('param');
        $medicines = Medicine::activated()->select('id', 'name')->where('name', 'like', '%' . $param . '%')->orderBy('name', 'asc')->latest()->take(10)->get();
        return response()->json([
            'items' => $medicines
        ]);
    }
}
