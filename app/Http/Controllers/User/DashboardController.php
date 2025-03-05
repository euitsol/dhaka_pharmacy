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
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(): View|RedirectResponse
    {
        try {
            // Get user with default address and zone
            $data['user'] = User::with([
                'address' => function ($query) {
                    $query->where('is_default', 1);
                },
                'address.zone'
            ])->findOrFail(user()->id);

            // Count payments
            $data['total_payments'] = Payment::where('customer_id', user()->id)->count();

            // Base query for orders
            $userId = user()->id;
            $userType = get_class(user());
            $query = Order::where([
                ['status', '!=', Order::INITIATED],  // Using constant instead of 0
                ['customer_id', $userId],
                ['customer_type', $userType]
            ])->latest();

            // Get counts for different order types
            $data['total_orders'] = (clone $query)->count();
            $data['total_current_orders'] = (clone $query)->whereIn('status', [
                Order::SUBMITTED,
                Order::HUB_ASSIGNED,
                Order::ITEMS_COLLECTING,
                Order::HUB_REASSIGNED,
                Order::ITEMS_COLLECTED,
                Order::PACHAGE_PREPARED,
                Order::DISPATCHED
            ])->count();
            $data['total_previous_orders'] = (clone $query)->where('status', Order::DELIVERED)->count();
            $data['total_cancel_orders'] = (clone $query)->whereIn('status', [
                Order::CANCELLED,
                Order::RETURNED
            ])->count();

            // Get products with precaution info - limit to 10 items to improve performance
            $orderProducts = (clone $query)
                ->with([
                    'products' => function($query) {
                        $query->whereHas('precaution')
                             ->with(['precaution', 'strength']);
                    }
                ])
                ->limit(10)  // Limit to recent orders for better performance
                ->get()
                ->pluck('products')
                ->flatten()
                ->filter(function($product) {
                    return $product->precaution !== null;
                })
                ->shuffle();

            $data['order_products'] = $orderProducts->take(10);  // Limit items shown in carousel

            // Get latest offers and tips
            $data['latest_offers'] = LatestOffer::activated()->latest()->get();
            $data['user_tips'] = UserTips::activated()->latest()->take(1)->get();

            return view('user.dashboard.dashboard', $data);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Dashboard error: ' . $e->getMessage());

            // Return with a flash message
            return redirect()->back()->with('error', 'Unable to load dashboard data. Please try again.');
        }
    }
}
