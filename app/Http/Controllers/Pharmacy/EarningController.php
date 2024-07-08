<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\Earning;
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
    public function index()
    {
        $pharmacyId = pharmacy()->id;
        $pharmacyClass = get_class(pharmacy());
        $query = Earning::with(['receiver', 'order', 'point_history'])
            ->where('receiver_id', $pharmacyId)
            ->where('receiver_type', $pharmacyClass)->latest();
        $totalEarnings = $query->get()->each(function ($earning) {
            $earning->point = $earning->amount / $earning->point_history->eq_amount;
        });
        $paginateEarnings = $query->paginate(1)->withQueryString();
        $data = [
            'totalEarnings' => $totalEarnings,
            'paginateEarnings' => $paginateEarnings,
            'pagination' => $paginateEarnings->links('vendor.pagination.bootstrap-5')->render(),
        ];

        return view('pharmacy.earning.index', $data);
    }
}