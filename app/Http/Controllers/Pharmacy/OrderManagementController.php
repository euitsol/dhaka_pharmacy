<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\OrderDistribution;
use App\Models\OrderDistributionPharmacy;
use App\Models\Pharmacy;
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
        $data['dops'] = OrderDistributionPharmacy::with(['od','cart','pharmacy'])->where('status',$this->getStatus($status))->where('pharmacy_id',pharmacy()->id)->get()->groupBy('order_distribution_id')
        ->map(function($dop,$key) use($status){
            $dop->od = OrderDistribution::findOrFail($key);
            $dop->statusTitle = $this->statusTitle($this->getStatus($status));
            $dop->statusBg = $this->statusBg($this->getStatus($status));
            return $dop;
        });
        return view('pharmacy.orders.index',$data);
    }
    
    public function details($do_id,$status){
        $data['do'] = OrderDistribution::with(['order','odps'])->findOrFail(decrypt($do_id));
        $data['do']->prep_time = $data['do']->readablePrepTime();
        $data['do']->pharmacy = Pharmacy::findOrFail(pharmacy()->id);
        $data['do']['dops'] = $data['do']->odps
                            ->where('status',$this->getStatus($status))
                            ->where('pharmacy_id',pharmacy()->id);
        $data['status'] = $this->getStatus($status);
        $data['statusTitle'] = $this->statusTitle($this->getStatus($status));
        $data['statusBg'] = $this->statusBg($this->getStatus($status));
        return view('pharmacy.orders.details',$data);
    }

    protected function getStatus($status){
        switch ($status) {
            case 'pending':
                return 0;
            case 'distributed':
                return 1;
            case 'dispute':
                return 2;
        }
    }

    protected function statusBg($status) {
        switch ($status) {
            case 0:
                return 'badge badge-warning';
            case 1:
                return 'badge badge-info';
            case 2:
                return 'badge badge-danger';
        }
    }
    
    protected function statusTitle($status) {
        switch ($status) {
            case 0:
                return 'pending';
            case 1:
                return 'distributed';
            case 2:
                return 'dispute';
        }
    }
}
