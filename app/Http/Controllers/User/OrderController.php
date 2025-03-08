<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Traits\TransformOrderItemTrait;
use App\Http\Traits\TransformProductTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Services\OrderService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderController extends Controller
{
    use TransformOrderItemTrait, TransformProductTrait;
    private OrderService $orderService;


    public function __construct(OrderService $orderservice)
    {
        $this->middleware('auth');
        $this->orderService = $orderservice;
    }

    public function list(Request $request):View|RedirectResponse
    {
        try {
            $this->orderService->setUser(auth()->user());
            $data = $request->all();
            $data['per_page'] = 5;
            $orders = $this->orderService->list($data);
            return view('user.order.list', compact('orders'));
        }catch (ModelNotFoundException $e) {
            flash()->addWarning($e->getMessage());
            return redirect()->back();
        }catch (Exception $e) {
            flash()->addWarning($e->getMessage());
            return redirect()->back();
        }
    }


    public function details($id): View|RedirectResponse
    {
        try {
            $this->orderService->setUser(user());
            $data['order'] = $this->orderService->getOrderDetails(decrypt($id), 'user');
            // dd($data['order']);
            return view('user.order.details', $data);
        }catch (ModelNotFoundException $e) {
            flash()->addWarning($e->getMessage());
            return redirect()->back();
        }catch (Exception $e) {
            flash()->addWarning($e->getMessage());
            return redirect()->back();
        }
        // $order = Order::with(['customer', 'address', 'payments', 'od.odrs', 'products.pro_cat', 'products.pro_sub_cat', 'products.units', 'products.discounts', 'products.pivot.unit', 'products.company', 'products.generic', 'products.strength'])->where('order_id', decrypt($id))->first();
        // $order->place_date = date('M d,Y', strtotime($order->created_at));
        // $this->calculateOrderTotalPrice($order);
        // $this->calculateOrderTotalDiscountPrice($order);
        // $order->totalRegularPrice = ($order->totalPrice - $order->totalDiscountPrice);
        // $order->statusBg = $order->statusBg();
        // $order->statusTitle = slugToTitle($order->statusTitle());
        // $order->products->each(function (&$product) {
        //     $this->transformProduct($product, 60);
        // });
        // if (isset($order->od) && $order->od->status == 4) {
        //     $order->otp = $order->od->delivery_active_otps->first()?->otp;
        // }
        // $data['order'] = $order;
        // return view('user.order.details', $data);
    }

    public function cancel($id): RedirectResponse
    {
        // dd(decrypt($id));
        try {
            $this->orderService->setUser(user());
            $this->orderService->setOrder(decrypt($id));
            $this->orderService->cancelOrder();

            flash()->success('Order cancelled successfully');
        }catch (ModelNotFoundException $e) {
            flash()->error('Something went wrong');
        } catch (Exception $e) {
            flash()->error('Something went wrong');
        }
        return redirect()->back();
    }


    private function buildOrderQuery($status)
    {
        $query = Order::where([
            ['customer_id', user()->id],
            ['customer_type', get_class(user())]
        ])->latest();

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
        $orders->getCollection()->each(function (&$order) {
            $order->place_date = date('d M Y h:m:s', strtotime($order->created_at));
            $this->calculateOrderTotalPrice($order);
            $this->calculateOrderTotalDiscountPrice($order);
            $order->totalRegularPrice = ($order->totalPrice - $order->totalDiscountPrice);
            $order->statusBg = $order->statusBg();
            $order->statusTitle = $order->statusTitle();
            $order->encrypt_oid = encrypt($order->id);
            $order->products->each(function (&$product) {
                $this->transformProduct($product, 30);
            });
            if (isset($order->od) && $order->od->status == 4) {
                $order->otp = $order->od->delivery_active_otps->first()?->otp;
            }
        });
    }
}
