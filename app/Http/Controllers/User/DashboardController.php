<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LatestOffer;
use App\Models\Order;
use App\Models\User;
use App\Models\UserTips;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Payment;


class DashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(): View
    {
        $data['user'] = User::with(['address' => function ($query) {
            $query->where('is_default', 1);
        }, 'address.zone'])->findOrFail(user()->id);
        $data['total_payments'] = Payment::where('customer_id', user()->id)->count();
        $query = Order::where([['status', '!=', 0], ['customer_id', user()->id], ['customer_type', get_class(user())]])->latest();
        $data['total_orders'] = (clone $query)->count();
        $data['total_current_orders'] = (clone $query)->whereIn('status', [1,2,3,4,5,6,7])->count();
        // $data['last_current_orders'] = (clone $query)->whereBetween('status', [1, 5])->first();
        $data['total_previous_orders'] = (clone $query)->where('status', 8)->count();
        $data['total_cancel_orders'] = (clone $query)->whereIn('status', [-1,-2])->count();
        $data['order_products'] = (clone $query)->with('products.precaution', 'products.strength')->get()->pluck('products')->flatten()->where('precaution', '!=', null)->shuffle();
        $data['latest_offers'] = LatestOffer::activated()->latest()->get();
        $data['user_tips'] = UserTips::activated()->latest()->get()->shuffle()->take(1);
        dd($data['order_products']);
        return view('user.dashboard.dashboard', $data);
    }
}
