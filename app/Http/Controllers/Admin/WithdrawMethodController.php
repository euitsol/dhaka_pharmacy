<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\WithdrawMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class WithdrawMethodController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function list($status): View
    {
        $data['status'] = $status;
        $data['wms'] = WithdrawMethod::status($status)->latest()->get();
        return view('admin.withdraw_method.list', $data);
    }
    public function details($id): View
    {
        $data['wm'] = WithdrawMethod::findOrFail(decrypt($id));
        return view('admin.withdraw_method.details', $data);
    }
    public function accept($id): RedirectResponse
    {
        $wm = WithdrawMethod::findOrFail(decrypt($id));
        $wm->status = 1;
        $wm->updater()->associate(admin());
        $wm->update();
        flash()->addSuccess('Withdraw method accepted successfully.');
        return redirect()->route('withdraw_method.wm_list', 'Verified');
    }
    public function declained($id): RedirectResponse
    {
        $wm = WithdrawMethod::findOrFail(decrypt($id));
        $wm->status = 1;
        $wm->updater()->associate(admin());
        $wm->update();
        flash()->addSuccess('Withdraw method accepted successfully.');
        return redirect()->route('withdraw_method.wm_list', 'Verified');
    }
}
