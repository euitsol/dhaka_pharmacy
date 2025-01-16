<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class DashboardController extends Controller
{
    public function __construct() {
        return $this->middleware('pharmacy');
    }

    public function dashboard(): View
    {
        return view('pharmacy.dashboard.dashboard');
    }
}
