<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\API\Order\InitiatedRequest;
use App\Http\Requests\API\Order\IntSingleOrderRequest;
use App\Http\Requests\API\Order\OrderConfirmRequest;
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
        }catch (\Exception $e) {
            return sendResponse(false, 'Something went wrong, please try again', null, 500);
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
        }catch (\Exception $e) {
            return sendResponse(false, 'Something went wrong, please try again', null, 500);
        }
    }
    public function details(Request $request): JsonResponse
    {
        try {
            $this->orderService->setUser(user: $request->user());
            $order = $this->orderService->getOrderDetails($request->order_id);
            return sendResponse(true, 'Order details retrived successfully', ['order' => $order]);
        }catch (ModelNotFoundException $e) {
            return sendResponse(false, $e->getMessage(), null, 404);
        }catch (\Exception $e) {
            return sendResponse(false, $e->getMessage(), null, 500);
        }


        // $user = $request->user();
        // $order = Order::with([
        //     'customer',
        //     'address',
        //     'payments',
        //     'od.odrs',
        //     'products.pro_cat',
        //     'products.pro_sub_cat',
        //     'products.units',
        //     'products.discounts',
        //     'products.company',
        //     'products.generic',
        //     'products.strength'
        // ])
        //     ->where('creater_type', get_class($user))
        //     ->where('creater_id', $user->id)
        //     ->where('id', $request->order_id)->first();
        // if ($order) {
        //     $order->products->each(function (&$product) {
        //         $product = $this->transformProduct($product);
        //     });
        //     $this->calculateOrderTotalDiscountPrice($order);
        //     return sendResponse(true, 'Order details retrived successfully', ['order' => $order]);
        // } else {
        //     return sendResponse(false, 'Something went wrong, please try again');
        // }
    }

    public function order_confirm(OrderConfirmRequest $request): JsonResponse
    {
        $user = $request->user();
        $address =  Address::where('creater_id', $user->id)->where('creater_type', get_class($user))->where('id', $request->address)->first();
        if (!$address) {
            return sendResponse(false, 'Address not found');
        }
        $order = Order::with(['products', 'address'])
            ->where('creater_type', get_class($user))
            ->where('creater_id', $user->id)
            ->where('id', $request->order_id)->first();
        if ($order) {
            $order->address_id = $request->address;
            $order->status = 1; //Order Submit
            $order->delivery_type = 0;
            $order->delivery_fee = $this->getDeliveryCharge($address->latitude, $address->longitude);
            $order->save();
            $this->calculateOrderTotalDiscountPrice($order);

            $payment = new Payment();
            $payment->customer()->associate($user);
            $payment->payment_method = $request->payment_method;
            $payment->amount = $order->totalDiscountPrice + $order->delivery_fee;
            $payment->order_id = $order->id;
            $payment->status = 0; //Initialize
            $payment->creater()->associate($user);
            $payment->save();
            return sendResponse(true, 'Order confirm successfully', ['payment_id' => $payment->id, 'amount' => $payment->amount, 'tran_id' => generateTranId()]);
        } else {
            return sendResponse(false, 'Something went wrong, please try again');
        }
    }

    public function list(Request $request): JsonResponse
    {
        $user = $request->user();
        $status = $request->status;
        $filter_val = $request->filter ?? 7;


        $query = $this->buildOrderQuery($user, $status);
        $query->with(['od', 'products.pro_sub_cat', 'products.units', 'products.discounts', 'products.pivot.unit', 'products.company', 'products.generic', 'products.strength']);
        if ($filter_val != 'all') {
            $query->where('created_at', '>=', Carbon::now()->subDays($filter_val));
        }
        $orders =  $query->latest()->get();
        $this->prepareOrderData($orders);
        return sendResponse(true, 'Order list retrived successfully', ['orders' => $orders]);
    }

    public function cancel(Request $request): JsonResponse
    {
        $user = $request->user();
        $order = Order::where('creater_type', get_class($user))
            ->where('creater_id', $user->id)
            ->where('id', $request->order_id)->first();
        if ($order && $order->status < 2 && $order->status != -1) {
            $order->update(['status' => -1]);
            return sendResponse(true, 'Order canceled successfully');
        } else {
            return sendResponse(false, 'You can not cancel order which is in progress. Please contact with our customer care team.');
        }
        return sendResponse(false, 'Something went wrong, please try again');
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
