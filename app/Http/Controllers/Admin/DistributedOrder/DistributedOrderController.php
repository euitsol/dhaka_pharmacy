<?php

namespace App\Http\Controllers\Admin\DistributedOrder;

use App\Http\Controllers\Controller;
use App\Http\Requests\DisputeOrderRequest;
use App\Http\Requests\OrderDistributionRiderRequest;
use App\Models\AddToCart;
use App\Models\OrderDistribution;
use App\Models\OrderDistributionPharmacy;
use App\Models\OrderDistributionRider;
use App\Models\Payment;
use App\Models\Pharmacy;
use App\Models\Rider;
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
        $data['pp_count'] = false;
        if($this->getStatus($status) == 0 || $this->getStatus($status) == 1){
            $data['pp_count'] = true;
        }
        $data['status'] = $status;
        $data['statusBg'] = $this->statusBg($this->getStatus($status));
        $data['dos'] = OrderDistribution::with(['order','odps'])
        ->withCount(['odps' => function ($query) {
            $query->where('status','!=', -1);
        }])
        ->where('status',$this->getStatus($status))->get()
        ->map(function($do){
            $do->order->totalPrice = AddToCart::with('product')
                ->whereIn('id', json_decode($do->order->carts))
                ->get()
                ->sum(function ($item) {
                    return (($item->product->discountPrice() * ($item->unit->quantity ?? 1)) * $item->quantity);
                });
            return $do;
        });
        return view('admin.distributed_order.index',$data);
    }
    public function dispute($status): View
    {
        $data['pp_count'] = true;
        $data['status'] = $status;
        $data['statusBg'] = $this->statusBg($this->getStatus($status));
        $data['dos'] = OrderDistribution::with(['order','odps'])
        ->withCount(['odps' => function ($query) {
            $query->where('status','!=', -1);
        }])
        ->get()
        ->map(function($do){
            $do->order->totalPrice = AddToCart::with('product')
                ->whereIn('id', json_decode($do->order->carts))
                ->get()
                ->sum(function ($item) {
                    return (($item->product->discountPrice() * ($item->unit->quantity ?? 1)) * $item->quantity);
                });
            return $do;
        })->filter(function($do){
            return $do->odps->where('status', 3)->isNotEmpty();
        });
        return view('admin.distributed_order.index',$data);
    }

    public function details($do_id): View
    {
        $data['do'] = OrderDistribution::with(['order', 'odps' => function ($query) {
            $query->where('status','!=', -1);
        }])
        ->withCount(['odps' => function ($query) {
            $query->where('status','!=', -1);
        }])
        ->findOrFail(decrypt($do_id));
        if($data['do']->status == 2){
            $data['riders'] = Rider::activated()->kycVerified()->latest()->get();
        }
        $data['totalPrice'] = $this->calculateTotalPrice($data['do']);
        $data['pharmacies'] = Pharmacy::activated()->kycVerified()->latest()->get();
        $data['do_rider'] = OrderDistributionRider::where('status','!=',0)->where('order_distribution_id',$data['do']->id)->first();




        return view('admin.distributed_order.details',$data);
    }


    private function calculateTotalPrice($orderDistribution) {
        return AddToCart::with('product')
            ->whereIn('id', json_decode($orderDistribution->order->carts))
            ->get()
            ->sum(function ($item){
                $discountedPrice = $item->product->discountPrice();
                $quantity = $item->quantity;
                $unitQuantity = $item->unit->quantity ?? 1;
                return ($discountedPrice * $unitQuantity * $quantity);
            });
    }
    // public function edit($do_id,$pid): View
    // {
    //     $data['do'] = OrderDistribution::with(['order','odps'])->findOrFail(decrypt($do_id));
    //     $data['do']->pharmacy = Pharmacy::findOrFail(decrypt($pid));
    //     $data['do']['dops'] = $data['do']->odps->where('pharmacy_id',decrypt($pid));
    //     $data['do']['dops']->map(function($dop) {
    //         $dop->cart->price = (($dop->cart->product->price*($dop->cart->unit->quantity ?? 1))*$dop->cart->quantity);
    //         $dop->cart->discount_price = (($dop->cart->product->discountPrice()*($dop->cart->unit->quantity ?? 1))*$dop->cart->quantity);
    //         $dop->cart->discount = (productDiscountAmount($dop->cart->product->id)*($dop->cart->unit->quantity ?? 1))*$dop->cart->quantity;
    //         return $dop->cart;
    //     });
    //     $data['totalPrice'] = collect($data['do']['dops'])->sum('cart.discount_price');
    //     $data['totalRegularPrice'] = collect($data['do']['dops'])->sum('cart.price');
    //     $data['totalDiscount'] = collect($data['do']['dops'])->sum('cart.discount');
    //     $data['pharmacies'] = Pharmacy::activated()->kycVerified()->latest()->get();
    //     return view('admin.distributed_order.edit',$data);
    // }


    public function update(DisputeOrderRequest $req){
        foreach ($req->datas as $data) {
            $old_dop = OrderDistributionPharmacy::findOrFail($data['dop_id']);
            if($old_dop->pharmacy_id !== $data['pharmacy_id']){
                $old_dop->status=-1;
                $old_dop->updater()->associate(admin());
                $old_dop->update();

                $new = new OrderDistributionPharmacy();
                $new->order_distribution_id = $old_dop->order_distribution_id;
                $new->cart_id = $data['cart_id'];
                $new->pharmacy_id = $data['pharmacy_id'];
                $new->creater()->associate(admin());
                $new->save();

            }
        }
        flash()->addSuccess('Dispute Order Updated Successfully.');
        return redirect()->back(); 
    }


    public function do_rider(OrderDistributionRiderRequest $req, $do_id){
        $do_id = decrypt($do_id);
        $do_rider = new OrderDistributionRider();
        $do_rider->rider_id = $req->rider_id;
        $do_rider->order_distribution_id = $do_id;
        $do_rider->priority = $req->priority;
        $do_rider->instraction = $req->instraction;
        $do_rider->save();
        OrderDistribution::findOrFail($do_id)->update(['status'=>3]);
        flash()->addSuccess('Assign rider '.$do_rider->rider->name.' succesfully.');
        return redirect()->back(); 

    }







    protected function getStatus($status){
        switch ($status) {
            case 'pending':
                return 0;
            case 'preparing':
                return 1;
            case 'waiting-for-rider':
                return 2;
            case 'waiting-for-pickup':
                return 3;
            case 'picked-up':
                return 4;
            case 'finish':
                return 5;
        }
    }
    public function statusBg($status) {
        switch ($status) {
            case 0:
                return 'badge badge-info';
            case 1:
                return 'badge badge-warning';
            case 2:
                return 'badge bg-secondary';
            case 3:
                return 'badge badge-danger';
            case 4:
                return 'badge badge-primary';
            case 5:
                return 'badge badge-success';
                
        }
    }

}