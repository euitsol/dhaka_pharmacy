<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AddToCart;
use App\Models\Order;
use App\Models\OrderDistribution;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Http\Traits\TransformOrderItemTrait;
use App\Http\Traits\TransformProductTrait;


class UserOrderController extends Controller
{
    use TransformOrderItemTrait;
    use TransformProductTrait;


    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function order_list(Request $request)
    {
        $query = Order::with(['od', 'address', 'customer', 'payments', 'ref_user'])
            ->where('status', '!=', 0)
            ->where('customer_id', user()->id)
            ->where('customer_type', get_class(user()))
            ->latest();
        $data['pageNumber'] = $request->query('page', 1);
        if ($data['pageNumber'] == 1) {
            $filter_val = request('filter');
            if ($filter_val && $filter_val != 'all') {
                $query->where('created_at', '>=', Carbon::now()->subDays($filter_val));
            }
        }
        $orders =  $query->paginate(5);
        $orders->getCollection()->each(function ($order) {
            $order->place_date = date('d M Y h:m:s', strtotime($order->created_at));
            $order->order_items = $this->getOrderItems($order);
            $order->totalPrice = $this->calculateOrderTotalPrice($order, $order->order_items);
            $order->totalRegularPrice = $this->calculateOrderTotalRegularPrice($order, $order->order_items);
            $order->totalDiscount = $this->calculateOrderTotalDiscount($order, $order->order_items);
            $order->order_items->each(function ($item) {
                $item->product = $this->transformProduct($item->product, 30);
                return $item;
            });
            return $order;
        });

        $data['orders'] = $orders;
        $data['pagination'] = $orders->links('vendor.pagination.bootstrap-5')->render();
        if (request()->ajax()) {
            return response()->json($data);
        } else {
            return view('user.order.order_list', $data);
        }
    }
}
