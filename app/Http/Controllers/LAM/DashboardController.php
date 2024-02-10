<?php

namespace App\Http\Controllers\LAM;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class DashboardController extends Controller
{
    public function __construct()
    {
        return $this->middleware('lam');
    }
    public function dashboard(): View
    {
        return view('local_area_manager.dashboard.dashboard');
    }
}
