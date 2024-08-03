<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentDeclinedRequest;
use App\Models\Earning;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class PaymentClearanceController extends Controller
{
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function list($activity): View
    {
        $data['activity'] = ucfirst($activity);
        $data['payments'] = Earning::with('point_history')->activity($data['activity'])->latest()->get();
        return view('admin.payment_clearance.list', $data);
    }
    public function details($id): View
    {
        $data['payment'] = Earning::with('point_history')->findOrFail(decrypt($id));
        return view('admin.payment_clearance.details', $data);
    }
    public function accept($id): RedirectResponse
    {
        $pc = Earning::findOrFail(decrypt($id));
        $pc->activity = 1;
        $pc->description = 'Payment has been successfully cleared';
        $pc->updater()->associate(admin());
        $pc->update();
        flash()->addSuccess('Payment has been successfully cleared.');
        return redirect()->route('pc.pc_list', 'pending-clearance');
    }
    public function declined(PaymentDeclinedRequest $request, $id): JsonResponse
    {
        try {
            $pc = Earning::findOrFail(decrypt($id));
            $pc->activity = -1;
            $pc->description = $request->declined_reason;
            $pc->updater()->associate(admin());
            $pc->update();
            flash()->addSuccess('Payment declined successfully.');
            return response()->json();
        } catch (\Exception $e) {
            flash()->addError('Somethings is wrong.');
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
}
