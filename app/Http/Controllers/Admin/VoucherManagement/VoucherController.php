<?php

namespace App\Http\Controllers\Admin\VoucherManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VoucherRequest;
use App\Models\Documentation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Voucher;
use App\Services\VoucherService;


class VoucherController extends Controller
{
    protected VoucherService $voucherService;
    public function __construct(VoucherService $voucherService)
    {
        $this->middleware('admin');
        $this->voucherService = $voucherService;
    }

    public function index(): View
    {
        $data['vouchers'] = $this->voucherService->getVouchers();
        return view('admin.voucher_management.vouchers.index', $data);
    }

    public function details(Voucher $id): JsonResponse
    {
        $voucher = $this->voucherService->getDetails($id);
        return response()->json($voucher);
    }

    public function create(): View
    {
        $data['document'] = Documentation::where([['module_key', 'voucher'], ['type', 'create']])->first();
        return view('admin.voucher_management.vouchers.create', $data);
    }

    public function store(VoucherRequest $req): RedirectResponse
    {
        try {
            $this->voucherService->createVoucher($req->validated());
            session()->flash('success', 'Voucher created successfully');
            return redirect()->route('vm.vouchers.voucher_list');
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong, please try again');
            return back()->withInput();
        }
    }
}