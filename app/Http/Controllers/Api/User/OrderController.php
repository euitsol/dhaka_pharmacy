<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\API\Order\AddressUpdateRequest;
use App\Http\Requests\API\Order\InitiatedRequest;
use App\Http\Requests\API\Order\IntSingleOrderRequest;
use App\Http\Requests\API\Order\OrderConfirmRequest;
use App\Http\Requests\API\Order\VoucherUpdateRequest;
use App\Http\Traits\DeliveryTrait;
use App\Models\AddToCart;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\JsonResponse;
use App\Http\Traits\TransformProductTrait;
use App\Http\Traits\TransformOrderItemTrait;
use App\Models\Address;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderController extends BaseController
{
    use TransformProductTrait, TransformOrderItemTrait, DeliveryTrait;

    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function int_order(InitiatedRequest $request): JsonResponse
    {
        try {
            $this->orderService->setUser($request->user());
            $order = $this->orderService->processOrder($request->validated());
            return sendResponse(true, 'Order initiated successfully', ['order_id' => $order->order_id]);
        }catch (ModelNotFoundException $e) {
            return sendResponse(false, $e->getMessage(), null, 404);
        }catch (Exception $e) {
            return sendResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function int_single_order(IntSingleOrderRequest $request): JsonResponse
    {
        try {
            $this->orderService->setUser($request->user());
            $order = $this->orderService->processOrder($request->validated(), isDirectOrder: true);
            return sendResponse(true, 'Order initiated successfully', ['order_id' => $order->order_id]);
        }catch (ModelNotFoundException $e) {
            return sendResponse(false, $e->getMessage(), null, 404);
        }catch (Exception $e) {
            return sendResponse(false, $e->getMessage(), null, 500);
        }
    }
    public function details(Request $request): JsonResponse
    {
        try {
            $this->orderService->setUser(user: $request->user());
            $order = $this->orderService->getOrderDetails($request->order_id, 'user');
            return sendResponse(true, 'Order details retrived successfully', ['order' => $order]);
        }catch (ModelNotFoundException $e) {
            return sendResponse(false, $e->getMessage(), null, 404);
        }catch (Exception $e) {
            return sendResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function address(AddressUpdateRequest $request): JsonResponse
    {
        try {
            $this->orderService->setUser($request->user());
            $this->orderService->setOrder($request->get('order_id', null));
            $this->orderService->addAddress($request->get('address_id', null), $request->get('delivery_type', null));
            return sendResponse(true, 'Address added successfully');
        }catch (ModelNotFoundException $e) {
            return sendResponse(false, $e->getMessage(), null, 404);
        }catch (Exception $e) {
            return sendResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function voucher(VoucherUpdateRequest $request): JsonResponse
    {
        try {
            $this->orderService->setUser($request->user());
            $this->orderService->setOrder($request->get('order_id', null));
            $this->orderService->addVoucher($request->get('voucher_code', null));
            return sendResponse(true, 'Voucher added successfully');
        }catch (ModelNotFoundException $e) {
            return sendResponse(false, $e->getMessage(), null, 404);
        }catch (Exception $e) {
            return sendResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function order_confirm(OrderConfirmRequest $request): JsonResponse
    {
        try {
            $this->orderService->setUser($request->user());
            $payment = $this->orderService->confirmOrder($request->validated());
            return sendResponse(true, 'Order confirm successfully', ['transaction_id' => $payment->transaction_id, 'amount' => $payment->amount, 'payment_method' => $payment->payment_method]);
        }catch (ModelNotFoundException $e) {
            return sendResponse(false, $e->getMessage(), null, 404);
        }catch (Exception $e) {
            return sendResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function list(Request $request): JsonResponse
    {
        $query = Order::select(['id','order_id', 'customer_id', 'customer_type', 'address_id', 'voucher_id', 'sub_total', 'voucher_discount', 'product_discount','total_amount', 'delivery_fee','delivery_type', 'status'])
            ->with([
            'customer:id,name,phone',
            'products:id,name,slug,status,pro_cat_id,pro_sub_cat_id,company_id,generic_id,strength_id,dose_id,price,image',
            'products.pro_cat:id,name,slug,status',
            'products.generic:id,name,slug,status',
            'products.pro_sub_cat:id,name,slug,status',
            'products.company:id,name,slug,status',
            'address:id,name,phone,city,street_address,latitude,longitude,apartment,floor,delivery_instruction,address',
            'voucher:id,code,type,discount_amount,usage_limit',
            'timelines.statusRule',
            'payments:id,order_id,customer_id,customer_type,amount,status,payment_method,transaction_id,creater_id,creater_type'
        ])
        ->where('customer_id', $request->user()->id)
        ->where('customer_type', get_class($request->user()));

        if($request->has('status')) {
            $statuses = is_array($request->status) 
                ? $request->status 
                : explode(',', $request->status);
            
            $query->whereIn('status', $statuses);
        }


        $orders = $query->paginate($request->get('per_page', 10))->withQueryString();



        // $user = $request->user();
        // $status = $request->status;
        // $filter_val = $request->filter ?? 7;


        // $query = $this->buildOrderQuery($user, $status);
        // $query->with(['od', 'products.pro_sub_cat', 'products.units', 'products.discounts', 'products.pivot.unit', 'products.company', 'products.generic', 'products.strength']);
        // if ($filter_val != 'all') {
        //     $query->where('created_at', '>=', Carbon::now()->subDays($filter_val));
        // }
        // $orders =  $query->latest()->get();
        // $this->prepareOrderData($orders);
        $additional = [
            'current_page' => $orders->currentPage(),
            'last_page' => $orders->lastPage(),
            'per_page' => $orders->perPage(),
            'total' => $orders->total(),
            'next_page_url' => $orders->nextPageUrl(),
            'prev_page_url' => $orders->previousPageUrl()
        ];

        return sendResponse(true, 'Order list retrived successfully', ['orders' => $query->get()], 200, $additional);
    }

    public function cancel(Request $request): JsonResponse
    {
        try {
            $this->orderService->setUser($request->user());
            $this->orderService->setOrder($request->get('order_id', null));
            $this->orderService->cancelOrder();
            return sendResponse(true, 'Order canceled successfully');
        }catch (ModelNotFoundException $e) {
            return sendResponse(false, $e->getMessage(), null, 404);
        }catch (Exception $e) {
            return sendResponse(false, $e->getMessage(), null, 500);
        }

        // $user = $request->user();
        // $order = Order::where('creater_type', get_class($user))
        //     ->where('creater_id', $user->id)
        //     ->where('id', $request->order_id)->first();
        // if ($order && $order->status < 2 && $order->status != -1) {
        //     $order->update(['status' => -1]);
        //     return sendResponse(true, 'Order canceled successfully');
        // } else {
        //     return sendResponse(false, 'You can not cancel order which is in progress. Please contact with our customer care team.');
        // }
        // return sendResponse(false, 'Something went wrong, please try again');
    }

    private function buildOrderQuery($user, $status)
    {
        $query = Order::where([
            ['customer_id', $user->id],
            ['customer_type', get_class($user)]
        ]);

        if ($status == 'current-orders') {
            $query->whereBetween('status', [0, 5]);
        } elseif ($status == 'previous-orders') {
            $query->where('status', 6);
        } elseif ($status == 'cancel-orders') {
            $query->where('status', -1);
        }

        return $query;
    }
    private function prepareOrderData($orders)
    {
        $orders->each(function (&$order) {
            $order->place_date = date('d M Y h:m:s', strtotime($order->created_at));
            $this->calculateOrderTotalPrice($order);
            $this->calculateOrderTotalDiscountPrice($order);
            $order->totalRegularPrice = ($order->totalPrice - $order->totalDiscountPrice);
            $order->products->each(function (&$product) {
                $this->transformProduct($product, 30);
            });
        });
    }
}
