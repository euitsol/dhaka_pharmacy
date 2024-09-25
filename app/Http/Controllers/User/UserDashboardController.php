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


class UserDashboardController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function dashboard(): View
    {
        $data['user'] = User::with(['address' => function ($query) {
            $query->where('is_default', 1);
        }])->findOrFail(user()->id);

        $query = Order::where([['status', '!=', 0], ['customer_id', user()->id], ['customer_type', get_class(user())]])->latest();

        $data['total_current_orders'] = (clone $query)->whereHas('od', function ($q) {
            $q->whereNotIn('status', [5, 6, 7]);
        })->orWhere('status', 1)->count();
        $data['total_previous_orders'] = (clone $query)->whereHas('od', function ($q) {
            $q->whereIn('status', [5, 6]);
        })->count();
        $data['total_cancel_orders'] = (clone $query)->whereHas('od', function ($q) {
            $q->where('status', 7);
        })->count();
        $data['order_products'] = (clone $query)->with('products.precaution', 'products.strength')->get()->pluck('products')->flatten()->where('precaution', '!=', null)->shuffle();
        $data['latest_offers'] = LatestOffer::activated()->latest()->get();
        $data['user_tips'] = UserTips::activated()->latest()->get()->shuffle()->take(1);
        return view('user.dashboard', $data);
    }
}
