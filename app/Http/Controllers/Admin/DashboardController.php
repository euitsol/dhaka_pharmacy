<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class DashboardController extends Controller
{
    public function __construct() {
        return $this->middleware('admin');
    }
    public function dashboard(){
        return view('admin.dashboard.dashboard');
    }
}
