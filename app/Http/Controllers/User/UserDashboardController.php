<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class UserDashboardController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('auth');
    }

    public function dashboard():View
    {
        flash()->addSuccess('Welcome to Dhaka Pharmacy');
        return view('user.dashboard');
    }
}
