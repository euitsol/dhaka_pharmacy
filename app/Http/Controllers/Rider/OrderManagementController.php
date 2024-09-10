<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerOtpVerifyRequest;
use App\Http\Requests\PharmacyOtpVerifyRequest;
use App\Http\Requests\Rider\RiderDisputeRequest;
use App\Models\DistributionOtp;
use App\Models\OrderDistribution;
use App\Models\OrderDistributionPharmacy;
use App\Models\OrderDistributionRider;
use App\Models\Pharmacy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Traits\TransformOrderItemTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class OrderManagementController extends Controller
{
    use TransformOrderItemTrait;
    public function __construct()
    {
        $this->middleware('rider');
    }

    public function index($status): View
    {
        // dd($status);
        // $data['status'] = $status;
        // $data['dors'] = OrderDistributionRider::with(['od.odps.pharmacy', 'od.order.address', 'rider'])
        //     ->where('rider_id', rider()->id)
        //     ->status($status)
        //     ->orderBy('priority', 'desc')
        //     ->latest()->get()
        //     ->each(function ($dor) {
        //         $dor->pharmacy = $dor->od->odps->pluck('pharmacy')->unique()->values();
        //         $dor->totalPrice = $this->calculateOrderTotalPrice($dor->od->order);
        //         return $dor;
        //     });

        switch ($status) {
            case 'assigned':
                $data['slug'] = 'assigned_orders';
                $data['dors'] = OrderDistributionRider::with(['od.active_odps.pharmacy', 'od.order.address', 'rider'])->where('rider_id', rider()->id)
                    ->where('status', 0)->orWhere('status', 1)
                    ->orderBy('priority', 'desc')
                    ->latest()->get()
                    ->each(function (&$dor) {
                        $this->calculateOrderTotalPrice($dor->od->order);
                    });
                break;
            case 'picked-up':
                $data['slug'] = 'picked_up_orders';
                $data['dors'] = OrderDistributionRider::with(['od.active_odps.pharmacy', 'od.order.address', 'rider'])->where('rider_id', rider()->id)
                    ->where('status', 2)->orWhere('status', 3)
                    ->orderBy('priority', 'desc')
                    ->latest()->get()
                    ->each(function (&$dor) {
                        $this->calculateOrderTotalPrice($dor->od->order);
                    });
                break;

            default:
                break;
        }
        return view('rider.orders.index', $data);
    }

    public function details($dor_id)
    {
        $data['dor'] = OrderDistributionRider::with(['od.active_odps', 'od.order.products', 'od.order.address', 'rider'])->findORFail(decrypt($dor_id));
        if ($data['dor']->status == 0) {
            $data['dor']->update(['status' => 1]);
        }
        $this->calculateOrderTotalDiscountPrice($data['dor']->od->order);
        return view('rider.orders.details', $data);
    }

    public function uOtpVerify(Request $request): RedirectResponse
    {
        $od = OrderDistribution::findOrFail(decrypt($request->od));
        $otp = $od->delivery_active_otps->where('rider_id', rider()->id)->first();
        $reqOtp = implode('', $request->otp);

        if (!empty($otp) && $otp->otp == $reqOtp) {
            DB::transaction(function () use ($od, $otp) {
                $od->status = 5; // rider delivered
                $od->rider_delivered_at = Carbon::now(); // rider delivered
                $od->save();

                $od->order->status = 6; //delivered
                $od->order->save();

                $od->odps()->update(['status' => 3]);

                $otp->status = 2; //verified
                $otp->save();

                if ($od->assignedRider) {
                    $assignedRider = $od->assignedRider->first();
                    if ($assignedRider) {
                        $assignedRider->status = 3; // picked up
                        $assignedRider->save();
                    }
                }

                flash()->addSuccess('Order delivered successfully.');
            });
        } else {
            flash()->addError('Something went wrong. Please try again');
        }

        return redirect()->back();
    }

    // public function pOtpVerify(PharmacyOtpVerifyRequest $req)
    // {

    //     $od_id = decrypt($req->od_id);
    //     $pharmacy_id = decrypt($req->pid);
    //     $pharmacy = Pharmacy::findOrFail($pharmacy_id);
    //     $otp = $req->collect_otp;

    //     $check = DistributionOtp::where([
    //         ['order_distribution_id', $od_id],
    //         ['otp_author_id', $pharmacy->id],
    //         ['otp_author_type', get_class($pharmacy)],
    //         ['otp', $otp]
    //     ])->first();

    //     if ($check) {
    //         $check->update([
    //             'status' => 1,
    //             'rider_id' => rider()->id
    //         ]);

    //         OrderDistributionPharmacy::where([
    //             ['order_distribution_id', $od_id],
    //             ['pharmacy_id', $pharmacy->id],
    //             ['status', 2]
    //         ])->update(['status' => 4]);

    //         flash()->addSuccess('Order collected from ' . $pharmacy->name . ' successfully.');
    //     } else {
    //         flash()->addError('Something is wrong, please try again.');
    //     }


    //     $all_collect = OrderDistributionPharmacy::where('order_distribution_id', $od_id)
    //         ->where('status', 2)
    //         ->with('pharmacy')
    //         ->get()
    //         ->every(function ($dop) use ($od_id) {
    //             return DistributionOtp::where([
    //                 ['order_distribution_id', $od_id],
    //                 ['otp_author_id', $dop->pharmacy->id],
    //                 ['otp_author_type', get_class($dop->pharmacy)],
    //                 ['status', 1]
    //             ])->exists();
    //         });
    //     if ($all_collect) {
    //         OrderDistributionRider::where([
    //             ['rider_id', rider()->id],
    //             ['order_distribution_id', $od_id],
    //             ['status', 1]
    //         ])->update(['status' => 3]);

    //         $od = OrderDistribution::with('order.customer')->findOrFail($od_id);
    //         $customer = $od->order->customer;

    //         DistributionOtp::create([
    //             'order_distribution_id' => $od_id,
    //             'otp_author_id' => $customer->id,
    //             'otp_author_type' => get_class($customer),
    //             'otp' => otp()
    //         ]);
    //     }
    //     return redirect()->back();
    // }


    // public function cOtpVerify(CustomerOtpVerifyRequest $req, $od_id)
    // {
    //     $od_id = decrypt($od_id);
    //     $od = OrderDistribution::with('order.customer')->findOrFail($od_id);
    //     $check = DistributionOtp::where([
    //         ['order_distribution_id', $od_id],
    //         ['otp_author_id', $od->order->customer->id],
    //         ['otp_author_type', get_class($od->order->customer)],
    //         ['otp', $req->delivered_otp]
    //     ])->first();
    //     if ($check) {
    //         $check->status = 1;
    //         $check->rider_id = rider()->id;
    //         $check->update();

    //         OrderDistributionRider::where([['rider_id', rider()->id], ['order_distribution_id', $od_id], ['status', 2]])
    //             ->update(['status' => 3]);
    //         $od->update(['status' => 5, 'rider_collected_at' => Carbon::now()]);

    //         OrderDistributionPharmacy::where([['order_distribution_id', $od_id], ['status', 4]])->update(['status' => 5]);
    //         flash()->addSuccess('Order delivered successfully.');
    //     } else {
    //         flash()->addError('Something is wrong please try again.');
    //     }
    //     return redirect()->back();
    // }
    public function dispute(RiderDisputeRequest $req, $od_id)
    {
        // OrderDistribution::findOrFail(decrypt($od_id))->update(['status' => -1]);
        OrderDistributionRider::where([['rider_id', rider()->id], ['order_distribution_id', decrypt($od_id)], ['status', 2]])
            ->update(['status' => -1, 'dispute_note' => $req->dispute_reason]);
        flash()->addSuccess('Order disputed successfully.');
        return redirect()->back();
    }

    public function get_otp(Request $request): JsonResponse
    {

        $odr = OrderDistributionRider::find($request->odrId);
        $odr->od->otps()->where('status', 1)->update(['status' => -1]);


        $p = Pharmacy::find($request->pharmacyId);

        $save = new DistributionOtp();
        $save->order_distribution_id = $odr->od->id;
        $save->otp = otp();
        $save->status = 1;
        $save->rider_id = rider()->id;
        // $save->created_by = rider()->id;
        $save->pharmacy_id = $request->pharmacyId;
        $save->save();



        return response()->json([
            'success' => true,
            'data' => [
                'otp' => $save,
                'pharmacy' => $p,
            ],
        ]);
    }

    protected function getStatus($status)
    {
        switch ($status) {
            case 'dispute':
                return 0;
            case 'old-dispute':
                return -1;
            case 'waiting-for-pickup':
                return 1;
            case 'picked-up':
                return 2;
            case 'delivered':
                return 3;
            case 'finish':
                return 4;
            case 'cancel':
                return 5;
        }
    }

    public function statusBg($status)
    {
        switch ($status) {
            case 0:
            case -1:
                return 'badge badge-danger';
            case 1:
                return 'badge bg-info';
            case 2:
                return 'badge badge-primary';
            case 3:
                return 'badge badge-dark';
            case 4:
                return 'badge badge-success';
            case 5:
                return 'badge badge-danger';
        }
    }
    public function statusTitle($status)
    {
        switch ($status) {
            case 0:
            case -1:
                return 'Dispute';
            case 1:
                return 'Waiting for Pickup';
            case 2:
                return 'Picked Up';
            case 3:
                return 'Delivered';
            case 4:
                return 'Finish';
            case 5:
                return 'Cancel';
        }
    }
}