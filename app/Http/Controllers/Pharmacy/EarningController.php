<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\PharmacyEarningReportRequest;
use App\Models\Earning;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class EarningController extends Controller
{
    public function __construct()
    {
        return $this->middleware('pharmacy');
    }
    public function index(Request $request)
    {
        $query = Earning::with(['receiver', 'order', 'point_history'])
            ->pharmacy()
            ->latest();
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
            return view('pharmacy.earning.index', $data);
        }
    }
    public function report(PharmacyEarningReportRequest $request)
    {

        $earnings = Earning::with(['receiver', 'order'])
            ->pharmacy()
            ->whereDate('created_at', '>=', $request->from_date)
            ->whereDate('created_at', '<=', $request->to_date)
            ->get();
        // dd($earnings);
        flash()->addSuccess('Email send successfully');
        return redirect()->back();
    }
}