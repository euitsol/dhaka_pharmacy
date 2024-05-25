<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Models\OrderDistributionRider;
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
            $query->where('status',-1);
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
        $data['dor'] = OrderDistributionRider::with(['od.odps','od.order.address','rider'])->findORFail($dor_id);
        $data['dor']->pharmacy = $data['dor']->od->odps->unique('pharmacy_id')->map(function($dop){
                return $dop->pharmacy;
            })->values();
        $data['dor']->totalPrice = $this->calculateTotalPrice($data['dor']->od);

        return view('rider.orders.details',$data);
    }
    // protected function getStatus($status){
    //     switch ($status) {
    //         case 'dispute':
    //             return 0;
    //         case 'old-dispute':
    //             return -1;
    //         case 'ongoing':
    //             return 3;
    //         case 'collect':
    //             return 4;
    //         case 'delivered':
    //             return 5;
    //         case 'complete':
    //             return 6;
    //         case 'cancel':
    //             return 7;
    //         case 'cancel-complete':
    //             return 8;
    //     }
    // }
    
    // public function statusBg($status) {
    //     switch ($status) {
    //         case 0:
    //         case -1:
    //             return 'badge badge-danger';
    //         case 3:
    //             return 'badge bg-info';
    //         case 4:
    //             return 'badge badge-primary';
    //         case 5:
    //             return 'badge badge-dark';
    //         case 6:
    //             return 'badge badge-success';
    //         case 7:
    //             return 'badge badge-danger';
    //         case 8:
    //             return 'badge badge-warning';
                
    //     }
    // }
    
    
    // public function statusTitle($status) {
    //     switch ($status) {
    //         case 0:
    //         case -1:
    //             return 'Dispute';
    //         case 3:
    //             return 'Ongoing';
    //         case 4:
    //             return 'Collect';
    //         case 5:
    //             return 'Delivered';
    //         case 6:
    //             return 'Complete';
    //         case 7:
    //             return 'Cancel';
    //         case 8:
    //             return 'Cancel Complete';
    //     }
    // }
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
