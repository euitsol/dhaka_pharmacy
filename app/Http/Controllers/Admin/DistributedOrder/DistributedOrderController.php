<?php

namespace App\Http\Controllers\Admin\DistributedOrder;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderDistributionRequest;
use App\Models\OrderDistribution;
use App\Models\OrderDistributionPharmacy;
use App\Models\Payment;
use App\Models\Pharmacy;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class DistributedOrderController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('admin');
    }

    public function index($status): View
    {
        $data['status'] = $status;
        $data['dos'] = OrderDistribution::with(['order','odps'])->where('status',$this->getStatus($status))->get()
                    ->map(function($do,$key){
                        $duration = Carbon::parse($do->prep_time)->diff(Carbon::parse($do->created_at));
                        $formattedDuration = '';
                        if ($duration->h > 0) {
                            $formattedDuration .= $duration->h . ' hours ';
                        }
                        if ($duration->i > 0) {
                            $formattedDuration .= $duration->i . ' minutes';
                        }
                        $do->prep_time = $do->readablePrepTime();
                        $do['dops'] = $do->odps->groupBy('pharmacy_id')
                        ->map(function($dop,$key){
                            $dop->pharmacy = Pharmacy::findOrFail($key);
                            return $dop;
                        });
                        return $do;
                    });
        return view('admin.distributed_order.index',$data);
    }

    public function details($do_id,$pid): View
    {
        $data['do'] = OrderDistribution::with(['order','odps'])->findOrFail(decrypt($do_id));
        $data['do']->prep_time = $data['do']->readablePrepTime();
        $data['do']->pharmacy = Pharmacy::findOrFail(decrypt($pid));
        $data['do']['dops'] = $data['do']->odps->where('pharmacy_id',decrypt($pid));
        $data['status'] = $this->getStatusTitle($data['do']->status);
        return view('admin.distributed_order.details',$data);
    }
    public function edit($do_id,$pid): View
    {
        $data['do'] = OrderDistribution::with(['order','odps'])->findOrFail(decrypt($do_id));
        $data['do']->pharmacy = Pharmacy::findOrFail(decrypt($pid));
        $data['do']['dops'] = $data['do']->odps->where('pharmacy_id',decrypt($pid));
        $data['status'] = $this->getStatusTitle($data['do']->status);




        $data['payments'] = Payment::where('order_id',$data['do']->order->id)->latest()->get();
        $data['do']['dops']->map(function($dop) {
            $dop->cart->price = (($dop->cart->product->price*($dop->cart->unit->quantity ?? 1))*$dop->cart->quantity);
            $dop->cart->regular_price = (($dop->cart->product->regular_price*($dop->cart->unit->quantity ?? 1))*$dop->cart->quantity);
            $dop->cart->discount = (productDiscountAmount($dop->cart->product->id)*($dop->cart->unit->quantity ?? 1))*$dop->cart->quantity;
            return $dop->cart;
        });
        $data['totalPrice'] = collect($data['do']['dops'])->sum('cart.price');
        $data['totalRegularPrice'] = collect($data['do']['dops'])->sum('cart.regular_price');
        $data['totalDiscount'] = collect($data['do']['dops'])->sum('cart.discount');
        $data['pharmacies'] = Pharmacy::activated()->latest()->get();
        return view('admin.distributed_order.edit',$data);
    }


    public function update(OrderDistributionRequest $req, $order_id, $status){
        $order_id = decrypt($order_id);
        $od = OrderDistribution::updateOrCreate(
            ['order_id' => $order_id],
            [
                'payment_type' => $req->payment_type,
                'distribution_type' => $req->distribution_type,
                'prep_time' => $req->prep_time,
                'note' => $req->note,
            ]
        );
        
        // Iterate through the datas and update or create OrderDistributionPharmacy entries
        foreach ($req->datas as $data) {
            OrderDistributionPharmacy::updateOrCreate(
                [
                    'order_distribution_id' => $od->id,
                    'cart_id' => $data['cart_id'],
                ],
                ['pharmacy_id' => $data['pharmacy_id']]
            );  
        }
        flash()->addSuccess('Order Distribution Updated Successfully.');
        return redirect()->route('do.do_list',$status); 
    }







    protected function getStatus($status){
        switch ($status) {
            case 'distributed':
                return 0;
            case 'preparing':
                return 1;
            case 'waiting-for-pickup':
                return 2;
            case 'picked-up':
                return 3;
            case 'finish':
                return 4;
        }
    }
    protected function getStatusTitle($status){
        switch ($status) {
            case 0:
                return 'distributed';
            case 1:
                return 'preparing';
            case 2:
                return 'waiting-for-pickup';
            case 3:
                return 'picked-up';
            case 4:
                return 'finish';
        }
    }

}
