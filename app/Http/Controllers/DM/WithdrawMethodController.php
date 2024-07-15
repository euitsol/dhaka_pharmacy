<?php

namespace App\Http\Controllers\DM;

use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawMethodRequest;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\Documentation;
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
        return $this->middleware('dm');
    }

    public function list()
    {
        $data['wms'] = WithdrawMethod::where('creater_id', dm()->id)->where('creater_type', get_class(dm()))->latest()->get();
        return view('district_manager.withdraw_method.list', $data);
    }
    public function details($id): JsonResponse
    {
        $data = WithdrawMethod::findOrFail(decrypt($id));
        $data->statusBg = $data->statusBg();
        $data->statusTitle = $data->statusTitle();
        $this->morphColumnData($data);
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key', 'withdraw_method')->first();
        return view('district_manager.withdraw_method.create', $data);
    }
    public function store(WithdrawMethodRequest $request): RedirectResponse
    {
        WithdrawMethod::create(
            [
                'bank_name' => $request->bank_name,
                'bank_brunch_name' => $request->bank_brunch_name,
                'routing_number' => $request->routing_number,
                'account_name' => $request->account_name,
                'type' => $request->type,
                'creater_id' => dm()->id,
                'creater_type' => get_class(dm()),
            ]
        );
        flash()->addSuccess('Withdraw method created successfully.');
        return redirect()->route('dm.wm.list');
    }
}