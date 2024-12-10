<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistrictManager;
use App\Models\LocalAreaManager;
use App\Models\OperationArea;
use App\Models\OperationSubArea;
use App\Models\Order;
use App\Models\Pharmacy;
use App\Models\Rider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function dashboard(): View
    {
        $data['customers'] = User::activated()->count();
        $data['pharmacies'] = Pharmacy::activated()->count();
        $data['dms'] = DistrictManager::activated()->count();
        $data['lams'] = LocalAreaManager::activated()->count();
        $data['riders'] = Rider::activated()->count();
        $data['opas'] = OperationArea::activated()->count();
        $data['opsas'] = OperationSubArea::activated()->count();

        // Days in the current month
        $daysInMonth = now()->daysInMonth;
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Days in the selected month
        $daysInMonth = now()->month($currentMonth)->daysInMonth;
        $chart_labels = range(1, $daysInMonth);

        // Fetch chart data
        // Fetch data for a specific status
        $dailyCounts = Order::selectRaw('DAY(created_at) as day, COUNT(*) as count')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupByRaw('DAY(created_at)')
            ->pluck('count', 'day')
            ->toArray();

        // Populate data for each day
        $chart_data = array_map(function ($day) use ($dailyCounts) {
            return $dailyCounts[$day] ?? 0;
        }, $chart_labels);

        $data['chart_labels'] = $chart_labels;
        $data['chart_data'] = $chart_data;
        return view('admin.dashboard.dashboard', $data);
    }

    public function chartUpdate(Request $request)
    {
        $status = $request->get('status', null);
        $currentMonth = $request->get('month', now()->month);
        $currentYear = now()->year;

        $daysInMonth = Carbon::create($currentYear, $currentMonth)->daysInMonth;
        $chart_labels = range(1, $daysInMonth);

        $query = Order::with('od.odrs');

        switch ($status) {
            case 1:
                $query->select('DAY(created_at) as day', DB::raw('COUNT(*) as count'))
                    ->groupBy('created_at');
                break;

            case 2:
                $query->join('order_distributions as od', 'od.order_id', '=', 'orders.id')
                    ->select('DAY(od.created_at) as day', DB::raw('COUNT(*) as count'))
                    ->groupBy('od.created_at');
                break;

            case 4:
                $query->join('order_distributions as od', 'od.order_id', '=', 'orders.id')
                    ->join('order_distribution_riders as odrs', 'odrs.order_id', '=', 'od.order_id')
                    ->select('DAY(odrs.created_at) as day', DB::raw('COUNT(*) as count'))
                    ->groupBy('odrs.created_at')
                    ->where('odrs.status', '!=', -1);  // Assuming that `-1` is an invalid status
                break;

            case 5:
                $query->join('order_distributions as od', 'od.order_id', '=', 'orders.id')
                    ->select('DAY(od.rider_collected_at) as day', DB::raw('COUNT(*) as count'))
                    ->groupBy('od.rider_collected_at');
                break;

            case 6:
                $query->join('order_distributions as od', 'od.order_id', '=', 'orders.id')
                    ->select('DAY(od.rider_delivered_at) as day', DB::raw('COUNT(*) as count'))
                    ->groupBy('od.rider_delivered_at');
                break;

            default:
                // If no valid status, just return the base query
                break;
        }
        $dailyCounts = $query->pluck('count', 'day')->toArray();

        dd($dailyCounts);


        // Populate data for each day, ensure days are included even with no data
        $chart_data = array_map(function ($day) use ($dailyCounts) {
            return $dailyCounts[$day] ?? 0;
        }, $chart_labels);

        // Return data for chart rendering
        $data['chart_labels'] = $chart_labels;
        $data['chart_data'] = $chart_data;

        return response()->json($data);
    }
}
