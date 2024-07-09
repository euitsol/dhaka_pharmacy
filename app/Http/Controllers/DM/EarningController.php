<?php

namespace App\Http\Controllers\DM;

use App\Http\Controllers\Controller;
use App\Http\Requests\EarningReportRequest;
use App\Models\Earning;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EarningController extends Controller
{
    public function __construct()
    {
        return $this->middleware('dm');
    }
    public function index(Request $request)
    {
        $query = Earning::with(['receiver', 'order', 'point_history'])
            ->dm();
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereDate('created_at', '>=', $request->from)
                ->whereDate('created_at', '<=', $request->to);
        }
        $totalEarnings = $query->get()->each(function (&$earning) {
            $earning->point = $earning->amount / $earning->point_history->eq_amount;
        });
        $paginateEarnings = $query->paginate(1)->withQueryString();
        $paginateEarnings->getCollection()->each(function (&$earning) {
            $earning->creationDate = timeFormate($earning->created_at);
            $earning->activityBg = $earning->activityBg();
            $earning->activityTitle = $earning->activityTitle();
        });
        $data = [
            'totalEarnings' => $totalEarnings,
            'paginateEarnings' => $paginateEarnings,
            'pagination' => $paginateEarnings->links('vendor.pagination.bootstrap-5')->render(),
        ];
        if ($request->ajax()) {
            return response()->json($data);
        } else {
            return view('district_manager.earning.index', $data);
        }
    }
    public function report(EarningReportRequest $request): JsonResponse
    {
        $query = Earning::with(['receiver', 'order'])->dm();
        if ($request->from_date != null && $request->to_date != null) {
            $query->whereDate('created_at', '>=', $request->from_date)
                ->whereDate('created_at', '<=', $request->to_date);
        }
        $earnings = $query->get();
        return response()->json([
            'success' => true,
            'message' => 'The email has been sent successfully.'
        ]);
    }
}