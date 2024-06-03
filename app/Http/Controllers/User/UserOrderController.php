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
        $status = $request->query('status', 'orders');
        $query = Order::query();
        if ($status == 'current-orders') {
            $query->with(['address', 'customer', 'payments', 'ref_user', 'od' => function ($q) {
                return $q->whereNotIn('status', [5, 6, 7]);
            }]);
        } elseif ($status == 'previous-orders') {
            $query->with(['address', 'customer', 'payments', 'ref_user', 'od' => function ($q) {
                return $q->whereIn('status', [5, 6]);
            }]);
        } elseif ($status == 'cancel-orders') {
            $query->with(['address', 'customer', 'payments', 'ref_user', 'od' => function ($q) {
                return $q->where('status', 7);
            }]);
        } else {
            $query->with(['address', 'customer', 'payments', 'ref_user', 'od']);
        }
        $query->where([['status', '!=', 0], ['customer_id', user()->id], ['customer_type', get_class(user())]])->latest();

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

    private function getStatus($textStatus)
    {
        if ($textStatus == 'current-orders') {
            return whereNotIn('status', [5, 6, 7]);
        }
    }
}
