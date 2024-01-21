<?php

namespace App\Http\Controllers\DM;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class DmProfileController extends Controller
{

    public function __construct() {
        return $this->middleware('dm');
    }

    public function profile():View
    {
        return view('district_manager.profile');
    }
}
