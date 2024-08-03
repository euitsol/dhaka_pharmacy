<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawDeclinedRequest;
use App\Models\Withdraw;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class WithdrawController extends Controller
{
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function list($status): View
    {
        $data['status'] = ucfirst($status);
        $data['withdrawals'] = Withdraw::status($status)->latest()->get();
        return view('admin.withdraw.list', $data);
    }
    public function details($id): View
    {
        $data['withdraw'] = Withdraw::with(['withdraw_method', 'receiver', 'earnings.point_history'])->findOrFail(decrypt($id));
        return view('admin.withdraw.details', $data);
    }
    public function accept($id): RedirectResponse
    {
        $w = Withdraw::with('earnings')->findOrFail(decrypt($id));
        $w->earnings->each(function (&$earning) {
            $earning->update(['activity' => 3, 'description' => 'Withdrawal completed successfully']);
        });
        // $w->load('earnings');
        $w->status = 1;
        $w->updater()->associate(admin());
        $w->update();
        flash()->addSuccess('Withdraw accepted successfully.');
        return redirect()->route('withdraw.w_list', 'accepted');
    }
    public function declined(WithdrawDeclinedRequest $request, $id): JsonResponse
    {
        try {
            $w = Withdraw::with('earnings')->findOrFail(decrypt($id));
            $w->earnings->each(function (&$earning) {
                $earning->update(['activity' => 4, 'description' => 'Withdraw declined']);
            });
            $w->status = 2;
            $w->reason = $request->declined_reason;
            $w->updater()->associate(admin());
            $w->update();
            flash()->addSuccess('Withdraw declined successfully.');
            return response()->json();
        } catch (\Exception $e) {
            flash()->addError('Somethings is wrong.');
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
}
