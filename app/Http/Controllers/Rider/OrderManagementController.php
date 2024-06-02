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


class OrderManagementController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('rider');
    }

    public function index($status): View
    {
        $data['status'] = $status;
        $query = OrderDistributionRider::with(['od.odps','od.order.address','rider'])->where('rider_id',rider()->id);
        $query->where('status',$this->getStatus($status));
        if($this->getStatus($status) == 0){
            $query->orWhere('status',-1);
        }
        $data['dors'] = $query->orderBy('priority','desc')->latest()->get()->map(function($dor){
            $dor->pharmacy = $dor->od->odps->unique('pharmacy_id')->map(function($dop){
                return $dop->pharmacy;
            })->values();
            $dor->totalPrice = $this->calculateTotalPrice($dor->od);
            return $dor;
        });
        return view('rider.orders.index',$data);
    }
    
    public function details($dor_id){
        $data['dor'] = OrderDistributionRider::with(['od.odps','od.order.address','rider'])->findORFail(decrypt($dor_id));
        $data['dor']->pharmacy = $data['dor']->od->odps->unique('pharmacy_id')->map(function($dop){
                return $dop->pharmacy;
            })->values();
        $data['dor']->totalPrice = $this->calculateTotalPrice($data['dor']->od);
        return view('rider.orders.details',$data);
    }

    public function pOtpVerify(PharmacyOtpVerifyRequest $req){
        $pharmacy = Pharmacy::findOrFail(decrypt($req->pid));
        $check = DistributionOtp::where('order_distribution_id',decrypt($req->od_id))->where('otp_author_id', $pharmacy->id)->where('otp_author_type', get_class($pharmacy))->where('otp',$req->collect_otp)->first();
        if($check){
            $check->status = 1;
            $check->rider_id = rider()->id;
            $check->update();

            OrderDistributionPharmacy::where('order_distribution_id', decrypt($req->od_id))
                                        ->where('status', 2)
                                        ->where('pharmacy_id',$pharmacy->id)
                                        ->update(['status'=>4]);
            flash()->addSuccess('Order collected from '.$pharmacy->name.' successfully.');
        }else{
            flash()->addError('Something is wrong please try again.');
        }

        $odps = OrderDistributionPharmacy::with('pharmacy')->where('order_distribution_id', decrypt($req->od_id))
                                        ->where('status', 2)
                                        ->get()
                                        ->unique('pharmacy_id');

        $all_collect = $odps->every(function ($dop) use ($req) {
            $check = DistributionOtp::where('order_distribution_id', decrypt($req->od_id))
                ->where('otp_author_id', $dop->pharmacy->id)
                ->where('otp_author_type', get_class($dop->pharmacy))
                ->first();
            return $check && $check->status == 1;
        });
        if($all_collect){
            OrderDistributionRider::where('rider_id',rider()->id)->where('order_distribution_id', decrypt($req->od_id))->where('status',1)->update(['status'=>2]);
            OrderDistribution::where('id', decrypt($req->od_id))->update(['status'=>4]);

            $od = OrderDistribution::with('order.customer')->findOrFail(decrypt($req->od_id));
            $CustomerVotp = new DistributionOtp();
            $CustomerVotp->order_distribution_id = $od->id;
            $CustomerVotp->otp_author()->associate($od->order->customer);
            $CustomerVotp->otp = otp();
            $CustomerVotp->save();
        }
        return redirect()->back(); 
    }
    public function cOtpVerify(CustomerOtpVerifyRequest $req, $od_id){
        $od = OrderDistribution::with('order.customer')->findOrFail(decrypt($od_id));
        $check = DistributionOtp::where('order_distribution_id',decrypt($od_id))->where('otp_author_id', $od->order->customer->id)->where('otp_author_type', get_class($od->order->customer))->where('otp',$req->delivered_otp)->first();
        if($check){
            $check->status = 1;
            $check->rider_id = rider()->id;
            $check->update();

            OrderDistributionRider::where('rider_id',rider()->id)->where('order_distribution_id', decrypt($od_id))->where('status',2)->update(['status'=>3]);
            OrderDistribution::where('id', decrypt($od_id))->update(['status'=>5]);

            OrderDistributionPharmacy::where('order_distribution_id', decrypt($od_id))
                                        ->where('status', 4)
                                        ->update(['status'=>5]);
            flash()->addSuccess('Order delivered successfully.');
        }else{
            flash()->addError('Something is wrong please try again.');
        }
        return redirect()->back();
    }
    public function dispute(RiderDisputeRequest $req, $od_id){
        OrderDistribution::findOrFail(decrypt($od_id))->update(['status'=>2]);
        OrderDistributionRider::where('rider_id',rider()->id)->where('order_distribution_id', decrypt($od_id))->where('status',1)->update(['status'=>0,'dispute_note'=>$req->dispute_reason]);
        flash()->addSuccess('Order disputed successfully.');
        return redirect()->back();
    }

    protected function getStatus($status){
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
    
    public function statusBg($status) {
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
    public function statusTitle($status) {
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
