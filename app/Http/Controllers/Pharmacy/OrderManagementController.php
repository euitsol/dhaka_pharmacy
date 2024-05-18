<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Requests\PharmacyOrderRequest;
use App\Models\OrderDistribution;
use App\Models\OrderDistributionPharmacy;
use App\Models\Pharmacy;
use App\Models\PharmacyDiscount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class OrderManagementController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('pharmacy');
    }

    public function index($status): View
    {
        $data['status'] = $status;
        $data['prep_time'] = false;
        if($this->getStatus($status) == 0 || $this->getStatus($status) == 1){
            $data['prep_time'] = true;
        }
        $query = OrderDistributionPharmacy::with(['cart','pharmacy','od'])->where('pharmacy_id',pharmacy()->id);
        $query->where('status',$this->getStatus($status));
        if($this->getStatus($status) == 3){
            $query->orWhere('status',-1);
        }
        $data['dops'] = $query->get()->groupBy('order_distribution_id')
        ->map(function($dop,$key) use($status){
            $dop->od = OrderDistribution::findOrFail($key);
            $dop->statusTitle = $this->statusTitle($this->getStatus($status));
            $dop->statusBg = $this->statusBg($this->getStatus($status));
            return $dop;
        });
        return view('pharmacy.orders.index',$data);
    }
    
    public function details($do_id,$status){
        
        $data['prep_time'] = false;
        if($this->getStatus($status) == 0 || $this->getStatus($status) == 1){
            $data['prep_time'] = true;
        }
        $data['pharmacy_discount'] = PharmacyDiscount::activated()->where('pharmacy_id',pharmacy()->id)->first();
        $data['do'] = OrderDistribution::with(['order','odps' => function ($query) use($status) {
            $query->where('status',$this->getStatus($status));
            if($this->getStatus($status) == 3){
                $query->orWhere('status',-1);
            }
        }])->findOrFail(decrypt($do_id));
        if($data['do']->odps->where('pharmacy_id', pharmacy()->id)->every(fn($odp) => $odp->status == 0)) {
            $data['do']->odps->where('pharmacy_id', pharmacy()->id)->each(function ($odp) {
                $odp->update(['status' => 1]);
            });
            $data['do']->update(['status' => 1]);
        }
        $data['do']->prep_time = readablePrepTime($data['do']->created_at, $data['do']->prep_time);
        $data['do']->pharmacy = Pharmacy::findOrFail(pharmacy()->id);
        $data['do']['dops'] = $data['do']->odps
                            ->where('pharmacy_id',pharmacy()->id);
        $data['status'] = $this->getStatus($status);
        $data['statusTitle'] = $this->statusTitle($this->getStatus($status));
        $data['statusBg'] = $this->statusBg($this->getStatus($status));
        return view('pharmacy.orders.details',$data);
    }

    public function update(PharmacyOrderRequest $req, $do_id){
        foreach($req->data as $data){
            $dop = OrderDistributionPharmacy::findOrFail($data['dop_id']);
            $dop->open_amount = $data['dop_id'];
            $dop->status = $data['status'];
            $dop->note = $data['note'];
            $dop->save();  
        }
        $do = OrderDistribution::findOrFail(decrypt($do_id));
        $odpsArray = $do->odps->toArray(); // Convert the collection to an array
        $statuses = array_column($odpsArray, 'status');
        $allValid = array_reduce($statuses, function ($carry, $status) {
            return $carry && ($status == 2 || $status == -1);
        }, true);

        if ($allValid) {
            $do->update(['status' => 2]);
        }
        flash()->addSuccess('Order distributed successfully.');
        return redirect()->route('pharmacy.order_management.index','waiting-for-rider');
    }


    protected function getStatus($status){
        switch ($status) {
            case 'pending':
                return 0;
            case 'preparing':
                return 1;
            case 'waiting-for-rider':
                return 2;
            case 'dispute':
                return 3;
            case 'old-disputed':
                return -1;
            case 'complete':
                return 4;
        }
    }
    
    public function statusBg($status) {
        switch ($status) {
            case 0:
                return 'badge badge-info';
            case 1:
                return 'badge badge-primary';
            case 2:
                return 'badge bg-secondary';
            case 3:
            case -1:
                return 'badge badge-danger';
            case 4:
                return 'badge badge-success';
                
        }
    }
    
    
    public function statusTitle($status) {
        switch ($status) {
            case 0:
                return 'pending';
            case 1:
                return 'preparing';
            case 2:
                return 'waiting-for-rider';
            case 3:
            case -1:
                return 'dispute';
            case 4:
                return 'complete';
        }
    }

    
    
}
