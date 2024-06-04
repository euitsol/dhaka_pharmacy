<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $status = $request->query('status', 'orders') ?? request('status');
        $query = Order::where([['status', '!=', 0], ['customer_id', user()->id], ['customer_type', get_class(user())]])->latest();
        if ($status == 'current-orders') {
            $query->whereHas('od', function ($q) {
                $q->whereNotIn('status', [5, 6, 7]);
            })->orWhere('status', 1);
        } elseif ($status == 'previous-orders') {
            $query->whereHas('od', function ($q) {
                $q->whereIn('status', [5, 6]);
            });
        } elseif ($status == 'cancel-orders') {
            $query->whereHas('od', function ($q) {
                $q->where('status', 7);
            });
        }
        $query->with(['address', 'customer', 'payments', 'ref_user', 'od']);
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
        $data['status'] = $status;
        $data['pagination'] = $orders->links('vendor.pagination.bootstrap-5')->render();
        if (request()->ajax()) {
            return response()->json($data);
        } else {
            return view('user.order.order_list', $data);
        }
    }
}
