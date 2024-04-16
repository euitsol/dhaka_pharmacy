<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class DashboardController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('rider');
    }

    public function dashboard(): View
    {
        return view('rider.dashboard.dashboard');
    }
}
