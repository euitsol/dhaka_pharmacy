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

    public function details(Voucher $id): View
    {
        $voucher = $this->voucherService->getDetails($id);
        return view('admin.voucher_management.vouchers.details', compact('voucher'));
    }

    public function create(): View
    {
        $data['document'] = Documentation::where([['module_key', 'voucher'], ['type', 'create']])->first();
        return view('admin.voucher_management.vouchers.create', $data);
    }

    public function store(VoucherRequest $req): RedirectResponse
    {
        try {
            $data = $req->validated();
            $data['created_by'] = admin()->id;
            $this->voucherService->createVoucher($data);
            session()->flash('success', 'Voucher created successfully');
            return redirect()->route('vm.vouchers.voucher_list');
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong, please try again');
            return back()->withInput();
        }
    }

    public function edit(Voucher $id): View
    {
        $data['document'] = Documentation::where([['module_key', 'voucher'], ['type', 'update']])->first();
        $data['voucher'] = $this->voucherService->getDetails($id);
        return view('admin.voucher_management.vouchers.edit', $data);
    }

    public function update(VoucherRequest $req, $id): RedirectResponse
    {

        try {
            $data = $req->validated();

            $data['updated_by'] = admin()->id;
            $this->voucherService->updateVoucher(Voucher::findOrFail($id), $data);
            session()->flash('success', 'Voucher updated successfully');
            return redirect()->route('vm.vouchers.voucher_list');
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong, please try again');
            return back()->withInput();
        }
    }

    public function delete(Voucher $id): RedirectResponse
    {
        try {
            $this->voucherService->deleteVoucher($id);
            session()->flash('success', 'Voucher deleted successfully');
            return redirect()->route('vm.vouchers.voucher_list');
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong, please try again');
            return back()->withInput();
        }
    }

    public function status(Voucher $id): RedirectResponse
    {
        try {
            $this->voucherService->statusChange($id);
            session()->flash('success', 'Voucher status changed successfully');
            return redirect()->route('vm.vouchers.voucher_list');
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong, please try again');
            return back()->withInput();
        }
    }
}