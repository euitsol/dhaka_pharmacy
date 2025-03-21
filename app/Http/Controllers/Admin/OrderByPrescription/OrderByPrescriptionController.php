<?php

namespace App\Http\Controllers\Admin\OrderByPrescription;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderByPrescriptionRequest;
use App\Http\Requests\API\AddressRequest as APIAddressRequest;
use App\Http\Requests\PrescriptionOrderCreateRequest;
use App\Http\Requests\User\AddressRequest;
use App\Models\Medicine;
use App\Models\OrderPrescription;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Http\Traits\TransformProductTrait;
use App\Models\AddToCart;
use App\Models\Order;
use App\Http\Traits\TransformOrderItemTrait;
use App\Models\Address;
use App\Models\OrderProduct;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\PrescriptionService;
use Exception;
use Illuminate\Http\RedirectResponse;
use App\Services\AddressService;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderByPrescriptionController extends Controller
{
    use TransformProductTrait, TransformOrderItemTrait;

    protected PrescriptionService $prescriptionService;
    protected AddressService $addressService;
    protected OrderService $orderService;

    public function __construct(PrescriptionService $prescriptionService, AddressService $addressService, OrderService $orderService)
    {
        $this->middleware('admin');
        $this->prescriptionService = $prescriptionService;
        $this->addressService = $addressService;
        $this->orderService = $orderService;
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
            $data['cities'] = $this->addressService->getCities();
            $this->addressService->setUser($data['details']->creater);
            $data['addresses'] = $this->addressService->list(true);
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

    public function productSearch(Request $request)
    {
        $param = $request->input('q');

        $query = Medicine::search($param);

        $data['products'] = $query->get()
            ->load(['units', 'pro_cat', 'generic', 'company', 'strength', 'discounts', 'dosage']);
        return response()->json([
            'items' => $data['products']
        ]);
    }

    public function addressList(Request $request)
    {
        $user_id = decrypt($request->data['user_id']);
        if($user_id){
            $data['user'] = User::findOrFail($user_id);
            $this->addressService->setUser($data['user']);
            $addresses = $this->addressService->list(true, null, $request->q);

            // Capture the mapped collection in a new variable (or reassign to $addresses)
            $mappedAddresses = $addresses->map(function($address) {
                return [
                    'id'         => $address['id'],
                    'name'       => $address['address'] . ' City: ' . $address['city'] . ' | ' . ($address['is_default'] ? 'Default' : 'Not Default') .' | Zone: '. $address['zone']['name'],
                    'address'    => $address['address'],
                    'is_default' => $address['is_default'],
                    'options'    => $address['delivery_options']
                ];
            });

            $data['addresses'] = $mappedAddresses;
            return response()->json($data);
        }else{
            return response()->json(null);
        }
    }

    public function storeAddressDetails(AddressRequest $request)
    {
        $user_id = decrypt($request->user_id);
        $user = User::findOrFail($user_id);
        try{
            $this->addressService->setUser($user)->create($request->validated());
            return response()->json(['status' => true]);
        }catch(Exception $e){
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function store(OrderByPrescriptionRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            // Get the user
            $user = User::findOrFail($validated['user_id']);

            // Process the order
            $order = $this->orderService
                ->setUser($user)
                ->processOrder([
                    'products' => $validated['products'],
                    'address_id' => $validated['address_id'],
                    'delivery_type' => $validated['delivery_type']
                ], true, 'prescription');

            // Update the order_prescription with order_id
            OrderPrescription::where('prescription_id', $validated['prescription_id'])
                ->update(['order_id' => $order->id, 'status' => OrderPrescription::STATUS_ACCEPTED]);

            // Prescription::find($validated['prescription_id'])->update(['status' => Prescription::STATUS_ACTIVE]);

            //Accept the order
            $this->orderService->setOrder($order->order_id);

            $payment = $this->orderService->confirmOrder([
                'payment_method' => $validated['payment_method']
            ]);

            DB::commit();

            flash()->addSuccess('Order created successfully.');
            return redirect()->back();

        } catch (Exception $e) {
            DB::rollBack();
            flash()->addWarning($e->getMessage());
            return redirect()->back();
        }
    }
    public function cancel($id)
    {
        try {
            DB::beginTransaction();

            $details = OrderPrescription::with(['creater', 'prescription'])->findOrFail(decrypt($id));

            if($details->order_id){
                $this->orderService->setOrder($details->order_id);
                $this->orderService->setUser($details->creater);
                $this->orderService->cancelOrder();
            }

            $details->update(['status' => OrderPrescription::STATUS_REJECTED]);
            // $details->prescription->update(['status' => Prescription::STATUS_INACTIVE]);

            DB::commit();
            flash()->addSuccess('Order cancelled successfully.');
            return redirect()->back();

        } catch (Exception $e) {
            DB::rollBack();
            flash()->addWarning($e->getMessage());
            return redirect()->back();
        }
    }
}
