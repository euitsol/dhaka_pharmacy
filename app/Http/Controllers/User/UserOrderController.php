<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Traits\TransformOrderItemTrait;
use App\Http\Traits\TransformProductTrait;
use Illuminate\View\View;
use Illuminate\Support\Facades\URL;

class UserOrderController extends Controller
{
    use TransformOrderItemTrait, TransformProductTrait;


    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function list(Request $request)
    {
        $status = $request->get('status') ?? request('status');
        $filter_val = $request->get('filter') ?? request('filter');
        $filter_val = $filter_val ?? 7;


        $query = $this->buildOrderQuery($status);
        $perPage = 2;
        $query->with(['od', 'products.pro_cat', 'products.pro_sub_cat', 'products.units', 'products.discounts', 'products.pivot.unit', 'products.company', 'products.generic', 'products.strength']);
        if ($filter_val && $filter_val != 'all') {
            $query->where('created_at', '>=', Carbon::now()->subDays($filter_val));
        }
        $orders =  $query->paginate($perPage)->withQueryString();
        $this->prepareOrderData($orders);

        $data = [
            'orders' => $orders,
            'status' => $status,
            'filterValue' => $filter_val,
            'pagination' => $orders->links('vendor.pagination.bootstrap-5')->render()
        ];
        if (request()->ajax()) {
            return response()->json($data);
        } else {
            return view('user.order.list', $data);
        }
    }


    public function details($id): View
    {
        $order = Order::with(['customer', 'address', 'payments', 'od', 'products.pro_cat', 'products.pro_sub_cat', 'products.units', 'products.discounts', 'products.pivot.unit', 'products.company', 'products.generic', 'products.strength'])->findOrFail(decrypt($id));
        $order->place_date = date('M d,Y', strtotime($order->created_at));
        $order->status_update_time = date('M d, h:ma', strtotime($order->updated_at));
        $this->calculateOrderTotalPrice($order);
        $this->calculateOrderTotalDiscountPrice($order);
        $order->totalRegularPrice = ($order->totalPrice - $order->totalDiscountPrice);
        $order->statusBg = $order->statusBg();
        $order->statusTitle = slugToTitle($order->statusTitle());
        $order->products->each(function (&$product) {
            $this->transformProduct($product, 60);
        });

        $data['order'] = $order;
        return view('user.order.details', $data);
    }



    private function buildOrderQuery($status)
    {
        $query = Order::where([
            ['status', '!=', 0],
            ['customer_id', user()->id],
            ['customer_type', get_class(user())]
        ])->latest();

        if ($status == 'current-orders') {
            $query->whereIn('status', [0, 1, 2, 3, 4]);
        } elseif ($status == 'previous-orders') {
            $query->whereIn('status', [-1, -2, -3]);
        } elseif ($status == 'cancel-orders') {
            $query->where('status', -2);
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
            $order->products->each(function (&$product) {
                $this->transformProduct($product, 30);
            });
        });
    }
}