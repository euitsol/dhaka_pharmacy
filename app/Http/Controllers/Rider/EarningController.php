<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Http\Requests\EarningReportRequest;
use App\Http\Requests\WithdrawConfirmRequest;
use App\Models\Earning;
use App\Models\Withdraw;
use App\Models\WithdrawEarning;
use App\Models\WithdrawMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EarningController extends Controller
{
    public function __construct()
    {
        return $this->middleware('rider');
    }
    public function index(Request $request)
    {
        $query = Earning::with('point_history')
            ->rider()
            ->latest();
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereDate('created_at', '>=', $request->from)
                ->whereDate('created_at', '<=', $request->to);
        }
        $totalEarnings = $query->get();
        $paginateEarnings = $query->with(['receiver', 'order', 'withdraw_earning.withdraw.withdraw_method'])->paginate(10)->withQueryString();
        $paginateEarnings->getCollection()->each(function (&$earning) {
            $earning->creationDate = timeFormate($earning->created_at);
            $earning->activityBg = $earning->activityBg();
            $earning->activityTitle = slugToTitle($earning->activityTitle());
        });
        $data = [
            'point_name' => getPointName(),
            'totalEarnings' => $totalEarnings,
            'paginateEarnings' => $paginateEarnings,
            'pagination' => $paginateEarnings->links('vendor.pagination.bootstrap-5')->render(),
        ];
        if ($request->ajax()) {
            return response()->json($data);
        } else {
            return view('rider.earning.index', $data);
        }
    }
    public function report(EarningReportRequest $request): JsonResponse
    {
        $query = Earning::with(['receiver', 'order'])->rider();
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
        $data['wms'] = WithdrawMethod::rider()->activated()->latest()->get();
        $data['earnings'] = Earning::with(['receiver', 'order', 'point_history'])->rider()->get();
        return view('rider.earning.withdraw', $data);
    }
    public function withdrawConfirm(WithdrawConfirmRequest $request)
    {
        DB::beginTransaction();

        try {
            $totalEarnings =  Earning::rider()->get();
            $pw_check = $totalEarnings->where('activity', 2)->first();
            if ($pw_check) {
                flash()->addInfo('You have a pending withdrawal request. Please wait for it to be completed.');
                return redirect()->back();
            }
            $rider = rider();
            $w_amount = $request->amount;
            $withdraw_method = $request->withdraw_method;
            $t_a_amount = getEarningEqAmounts($totalEarnings);

            if ($t_a_amount < $w_amount) {
                flash()->addWarning('Insufficient balance.');
                return redirect()->back();
            }

            $earnings = Earning::with(['point_history'])
                ->selectRaw('ph_id, SUM(point) as total_points, SUM(eq_amount) as total_eq_amount')
                ->where('activity', 1)
                ->rider()
                ->groupBy('ph_id')
                ->get();

            $withdraw = new Withdraw();
            $withdraw->receiver()->associate($rider);
            $withdraw->wm_id = $withdraw_method;
            $withdraw->amount = $w_amount;
            $withdraw->creater()->associate($rider);
            $withdraw->save();

            foreach ($earnings as $er) {
                if ($w_amount != 0) {
                    $a_points = $er->total_points;
                    $a_amount = $er->total_eq_amount;
                    $w_point = $w_amount / $er->point_history->eq_amount;

                    if ($a_points >= $w_point) {
                        $earning = new Earning();
                        $earning->ph_id = $er->ph_id;
                        $earning->receiver()->associate($rider);
                        $earning->point = $w_point;
                        $earning->eq_amount = $w_amount;
                        $earning->activity = 2; // Withdraw Pending
                        $earning->description = 'Withdrawal request submitted successfully';
                        $earning->creater()->associate($rider);
                        $earning->save();

                        $w_er = new WithdrawEarning();
                        $w_er->w_id = $withdraw->id;
                        $w_er->e_id = $earning->id;
                        $w_er->creater()->associate($rider);
                        $w_er->save();
                        break;
                    } else {
                        $earning = new Earning();
                        $earning->ph_id = $er->ph_id;
                        $earning->receiver()->associate($rider);
                        $earning->point = $a_points;
                        $earning->eq_amount = $a_amount;
                        $earning->activity = 2; // Withdraw Pending
                        $earning->description = 'Withdrawal request submitted successfully';
                        $earning->creater()->associate($rider);
                        $earning->save();

                        $w_er = new WithdrawEarning();
                        $w_er->w_id = $withdraw->id;
                        $w_er->e_id = $earning->id;
                        $w_er->creater()->associate($rider);
                        $w_er->save();

                        $w_amount -= $a_amount;
                    }
                }
            }

            DB::commit();

            flash()->addSuccess('Your withdrawal request has been successfully sent.');
            return redirect()->route('rider.earning.index');
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->addError('Your withdrawal request has failed. Please try again.');
            return redirect()->back();
        }
    }
}
