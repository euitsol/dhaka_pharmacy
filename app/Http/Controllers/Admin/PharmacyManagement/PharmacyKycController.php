<?php

namespace App\Http\Controllers\Admin\PharmacyManagement;

use App\Http\Controllers\Controller;
use App\Models\SubmittedKyc;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class PharmacyKycController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $s['datas'] = SubmittedKyc::where('type','pharmacy')->latest()->get();
        return view('admin.pharmacy_management.submitted_kyc.index',$s);

    }
}
