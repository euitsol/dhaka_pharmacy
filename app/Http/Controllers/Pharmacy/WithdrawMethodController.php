<?php

namespace App\Http\Controllers\Pharmacy;

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
        return $this->middleware('pharmacy');
    }

    public function list()
    {
        $data['wms'] = WithdrawMethod::pharmacy()->latest()->get();
        return view('pharmacy.withdraw_method.list', $data);
    }
    public function details($id): JsonResponse
    {
        $data = WithdrawMethod::findOrFail(decrypt($id));
        $data->statusBg = $data->statusBg();
        $data->statusTitle = $data->statusTitle();
        $data->typeTitle = $data->type();
        $this->morphColumnData($data);
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key', 'withdraw_method')->first();
        return view('pharmacy.withdraw_method.create', $data);
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
                'creater_id' => pharmacy()->id,
                'creater_type' => get_class(pharmacy()),
            ]
        );
        flash()->addSuccess('Withdraw method add request submitted successfully.');
        return redirect()->route('pharmacy.wm.list');
    }
}
