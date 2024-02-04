<?php

namespace App\Http\Controllers\LAM;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class LamProfileController extends Controller
{
   
    public function __construct() {
        return $this->middleware('lam');
    }

    public function profile():View
    {
        return view('local_area_manager.profile');
    }
}
