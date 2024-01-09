<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class PharmacyProfileController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('pharmacy');
    }

    public function profile():View
    {
        return view('pharmacy.profile');
    }

}
