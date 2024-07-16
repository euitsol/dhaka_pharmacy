<?php

namespace App\Http\Controllers\DM;

use App\Http\Controllers\Controller;
use App\Http\Requests\EarningReportRequest;
use App\Http\Requests\WithdrawConfirmRequest;
use App\Models\Earning;
use App\Models\Withdraw;
use App\Models\WithdrawEarning;
use App\Models\WithdrawMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EarningController extends Controller
{
    public function __construct()
    {
        return $this->middleware('dm');
    }
    public function index(Request $request)
    {
        $query = Earning::with(['receiver', 'order', 'point_history'])
            ->dm()->latest();
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereDate('created_at', '>=', $request->from)
                ->whereDate('created_at', '<=', $request->to);
        }
        $totalEarnings = $query->get();
        $paginateEarnings = $query->paginate(10)->withQueryString();
        $paginateEarnings->getCollection()->each(function (&$earning) {
            $earning->creationDate = timeFormate($earning->created_at);
            $earning->activityBg = $earning->activityBg();
            $earning->activityTitle = $earning->activityTitle();
        });
        $data = [
            'totalEarnings' => $totalEarnings,
            'paginateEarnings' => $paginateEarnings,
            'pagination' => $paginateEarnings->links('vendor.pagination.bootstrap-5')->render(),
        ];
        if ($request->ajax()) {
            return response()->json($data);
        } else {
            return view('district_manager.earning.index', $data);
        }
    }
    public function report(EarningReportRequest $request): JsonResponse
    {
        $query = Earning::with(['receiver', 'order'])->dm();
        if ($request->from_date != null && $request->to_date != null) {
            $query->whereDate('created_at', '>=', $request->from_date)
                ->whereDate('created_at', '<=', $request->to_date);
        }
        $earnings = $query->get();
        return response()->json([
            'success' => true,
            'message' => 'The email has been sent successfully.'
        ]);
    }

    public function withdraw()
    {
        $data['wms'] = WithdrawMethod::dm()->activated()->latest()->get();
        $data['earnings'] = Earning::with(['receiver', 'order', 'point_history'])->dm()->get();
        return view('district_manager.earning.withdraw', $data);
    }
    public function withdrawConfirm(WithdrawConfirmRequest $request)
    {
        $w_amount = $request->amount;
        $withdraw_method = $request->withdraw_method;
        $t_a_amount = getEarningEqAmounts(Earning::dm()->get());

        if ($t_a_amount < $w_amount) {
            flash()->addError('Insuficient balance.');
            return redirect()->back();
        }

        $earnings = Earning::with(['point_history'])
            ->selectRaw('ph_id, SUM(point) as total_points, SUM(eq_amount) as total_eq_amount')
            ->where('activity', 1)
            ->dm()
            ->groupBy('ph_id')
            ->get();

        $withdraw = new Withdraw();
        $withdraw->receiver()->associate(dm());
        $withdraw->wm_id = $withdraw_method;
        $withdraw->amount = $w_amount;
        $withdraw->creater()->associate(dm());
        $withdraw->save();

        foreach ($earnings as $er) {
            if ($w_amount != 0) {
                $a_points = $er->total_points;
                $a_amount = $er->total_eq_amount;
                $w_point = $w_amount / $er->point_history->eq_amount;

                if ($a_points >= $w_point) {
                    $earning = new Earning();
                    $earning->ph_id = $er->ph_id;
                    $earning->receiver()->associate(dm());
                    $earning->point = $w_point;
                    $earning->eq_amount = $w_amount;
                    $earning->activity = 4; //Withdraw Pending
                    $earning->description = 'Withdrawal request submitted successfully';
                    $earning->creater()->associate(dm());
                    $earning->save();

                    $w_er = new WithdrawEarning();
                    $w_er->w_id = $withdraw->id;
                    $w_er->e_id = $earning->id;
                    $w_er->creater()->associate(dm());
                    $w_er->save();
                    break;
                } else {
                    $earning = new Earning();
                    $earning->ph_id = $er->ph_id;
                    $earning->receiver()->associate(dm());
                    $earning->point = $a_points;
                    $earning->eq_amount = $a_amount;
                    $earning->activity = 4; //Withdraw Pending
                    $earning->description = 'Withdrawal request submitted successfully';
                    $earning->creater()->associate(dm());
                    $earning->save();

                    $w_er = new WithdrawEarning();
                    $w_er->w_id = $withdraw->id;
                    $w_er->e_id = $earning->id;
                    $w_er->creater()->associate(dm());
                    $w_er->save();

                    $w_amount -= $a_amount;
                }
            }
        }
        flash()->addSuccess('Your withdrawal request has been successfully sent.');
        return redirect()->route('dm.earning.index');
    }
}
