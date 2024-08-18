<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderStatusChangeEvent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }
    public function dashboard(): View
    {
        return view('admin.dashboard.dashboard');
    }
}
