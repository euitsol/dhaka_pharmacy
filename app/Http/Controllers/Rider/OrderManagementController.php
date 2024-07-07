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


class OrderManagementController extends Controller
{
    use TransformOrderItemTrait;
    public function __construct()
    {
        return $this->middleware('rider');
    }

    public function index($status): View
    {
        $data['status'] = $status;
        $data['dors'] = OrderDistributionRider::with(['od.odps.pharmacy', 'od.order.address', 'rider'])
            ->where('rider_id', rider()->id)
            ->status($status)
            ->orderBy('priority', 'desc')
            ->latest()->get()
            ->each(function ($dor) {
                $dor->pharmacy = $dor->od->odps->pluck('pharmacy')->unique()->values();
                $dor->totalPrice = $this->calculateOrderTotalPrice($dor->od->order);
                return $dor;
            });
        return view('rider.orders.index', $data);
    }

    public function details($dor_id)
    {
        $data['dor'] = OrderDistributionRider::with(['od.odps', 'od.order.address', 'rider'])->findORFail(decrypt($dor_id));
        if ($data['dor']->status == 1) {
            $data['dor']->update(['status' => 2]);
        }
        $data['dor']->pharmacy = $data['dor']->od->odps->pluck('pharmacy')->unique()->values();
        $this->calculateOrderTotalDiscountPrice($data['dor']->od->order);
        return view('rider.orders.details', $data);
    }

    public function pOtpVerify(PharmacyOtpVerifyRequest $req)
    {

        $od_id = decrypt($req->od_id);
        $pharmacy_id = decrypt($req->pid);
        $pharmacy = Pharmacy::findOrFail($pharmacy_id);
        $otp = $req->collect_otp;

        $check = DistributionOtp::where([
            ['order_distribution_id', $od_id],
            ['otp_author_id', $pharmacy->id],
            ['otp_author_type', get_class($pharmacy)],
            ['otp', $otp]
        ])->first();

        if ($check) {
            $check->update([
                'status' => 1,
                'rider_id' => rider()->id
            ]);

            OrderDistributionPharmacy::where([
                ['order_distribution_id', $od_id],
                ['pharmacy_id', $pharmacy->id],
                ['status', 2]
            ])->update(['status' => 4]);

            flash()->addSuccess('Order collected from ' . $pharmacy->name . ' successfully.');
        } else {
            flash()->addError('Something is wrong, please try again.');
        }


        $all_collect = OrderDistributionPharmacy::where('order_distribution_id', $od_id)
            ->where('status', 2)
            ->with('pharmacy')
            ->get()
            ->every(function ($dop) use ($od_id) {
                return DistributionOtp::where([
                    ['order_distribution_id', $od_id],
                    ['otp_author_id', $dop->pharmacy->id],
                    ['otp_author_type', get_class($dop->pharmacy)],
                    ['status', 1]
                ])->exists();
            });
        if ($all_collect) {
            OrderDistributionRider::where([
                ['rider_id', rider()->id],
                ['order_distribution_id', $od_id],
                ['status', 1]
            ])->update(['status' => 3]);

            $od = OrderDistribution::with('order.customer')->findOrFail($od_id);
            $customer = $od->order->customer;

            DistributionOtp::create([
                'order_distribution_id' => $od_id,
                'otp_author_id' => $customer->id,
                'otp_author_type' => get_class($customer),
                'otp' => otp()
            ]);
        }
        return redirect()->back();
    }
    public function cOtpVerify(CustomerOtpVerifyRequest $req, $od_id)
    {
        $od_id = decrypt($od_id);
        $od = OrderDistribution::with('order.customer')->findOrFail($od_id);
        $check = DistributionOtp::where([
            ['order_distribution_id', $od_id],
            ['otp_author_id', $od->order->customer->id],
            ['otp_author_type', get_class($od->order->customer)],
            ['otp', $req->delivered_otp]
        ])->first();
        if ($check) {
            $check->status = 1;
            $check->rider_id = rider()->id;
            $check->update();

            OrderDistributionRider::where([['rider_id', rider()->id], ['order_distribution_id', $od_id], ['status', 2]])
                ->update(['status' => 3]);
            $od->update(['status' => 5]);

            OrderDistributionPharmacy::where([['order_distribution_id', $od_id], ['status', 4]])->update(['status' => 5]);
            flash()->addSuccess('Order delivered successfully.');
        } else {
            flash()->addError('Something is wrong please try again.');
        }
        return redirect()->back();
    }
    public function dispute(RiderDisputeRequest $req, $od_id)
    {
        OrderDistribution::findOrFail(decrypt($od_id))->update(['status' => 2]);
        OrderDistributionRider::where([['rider_id', rider()->id], ['order_distribution_id', decrypt($od_id)], ['status', 1]])
            ->update(['status' => 0, 'dispute_note' => $req->dispute_reason]);
        flash()->addSuccess('Order disputed successfully.');
        return redirect()->back();
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
