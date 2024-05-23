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

    // public function update(PharmacyOrderRequest $req, $do_id){
    //     foreach($req->data as $data){
    //         $dop = OrderDistributionPharmacy::findOrFail($data['dop_id']);
    //         $dop->open_amount = $data['dop_id'];
    //         $dop->status = $data['status'];
    //         $dop->note = $data['note'];
    //         $dop->save();  
    //     }
    //     $do = OrderDistribution::findOrFail(decrypt($do_id));
    //     $odpsArray = $do->odps->toArray(); // Convert the collection to an array
    //     $statuses = array_column($odpsArray, 'status');
    //     $allValid = array_reduce($statuses, function ($carry, $status) {
    //         return $carry && ($status == 2 || $status == -1);
    //     }, true);

    //     if ($allValid) {
    //         $do->update(['status' => 2]);
    //     }
    //     flash()->addSuccess('Order distributed successfully.');
    //     return redirect()->route('pharmacy.order_management.index','waiting-for-rider');
    // }

    protected function getStatus($status){
        switch ($status) {
            case 'dispute':
                return 0;
            case 'old-dispute':
                return -1;
            case 'ongoing':
                return 3;
            case 'collect':
                return 4;
            case 'delivered':
                return 5;
            case 'complete':
                return 6;
            case 'cancel':
                return 7;
            case 'cancel-complete':
                return 8;
        }
    }
    
    public function statusBg($status) {
        switch ($status) {
            case 0:
            case -1:
                return 'badge badge-danger';
            case 3:
                return 'badge bg-info';
            case 4:
                return 'badge badge-primary';
            case 5:
                return 'badge badge-dark';
            case 6:
                return 'badge badge-success';
            case 7:
                return 'badge badge-danger';
            case 8:
                return 'badge badge-warning';
                
        }
    }
    
    
    public function statusTitle($status) {
        switch ($status) {
            case 0:
            case -1:
                return 'Dispute';
            case 3:
                return 'Ongoing';
            case 4:
                return 'Collect';
            case 5:
                return 'Delivered';
            case 6:
                return 'Complete';
            case 7:
                return 'Cancel';
            case 8:
                return 'Cancel Complete';
        }
    }
}
