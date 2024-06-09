<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
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
    public function list(): View
    {
        $data['ups'] = OrderPrescription::with(['customer', 'address'])->orderBy('status', 'asc')->get();
        return view('admin.order_by_prescription.list', $data);
    }
    public function details($id): View
    {
        $id = decrypt($id);
        $data['up'] = OrderPrescription::with(['customer', 'address'])->findOrFail($id);
        $data['medichines'] = Medicine::activated()->orderBy('name', 'asc')->get();
        return view('admin.order_by_prescription.details', $data);
    }
}