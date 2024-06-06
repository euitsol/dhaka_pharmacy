<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderPrescription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class OrderByPrescriptionController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('admin');
    }
    public function list()
    {
        $data['ups'] = OrderPrescription::with('customer')->orderBy('status', 'asc')->get();
        return view('admin.order_by_prescription.list', $data);
    }
}
