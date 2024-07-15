<?php

namespace App\Http\Controllers\DM;

use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawMethodRequest;
use App\Models\Documentation;
use App\Models\WithdrawMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class WithdrawMethodController extends Controller
{
    public function __construct()
    {
        return $this->middleware('dm');
    }

    public function details()
    {
        $data['wm'] = WithdrawMethod::where('creater_id', dm()->id)->where('creater_type', get_class(dm()))->first();
        $data['document'] = Documentation::where('module_key', 'withdraw_method')->first();
        return view('district_manager.withdraw_method.index', $data);
    }
    public function update(WithdrawMethodRequest $request)
    {
        $check = WithdrawMethod::where('creater_id', dm()->id)->where('creater_type', get_class(dm()))->first();
        if ($check && $check->status == 1) {
            flash()->addError('Your payment method has already been verified.');
        } elseif ($check && empty($check->note)) {
            flash()->addError('You have already submitted your payment method details. Please wait for verification.');
        } else {
            WithdrawMethod::updateOrCreate(
                [
                    'creater_id' => dm()->id,
                    'creater_type' => get_class(dm()),
                ],
                [
                    'bank_name' => $request->bank_name,
                    'bank_brunch_name' => $request->bank_brunch_name,
                    'routing_number' => $request->routing_number,
                    'account_name' => $request->account_name,
                    'type' => $request->type,
                ]
            );
            flash()->addSuccess('Your payment method has been updated successfully. Please wait to verify.');
        }

        return redirect()->route('dm.wm.details');
    }
}
