<?php

namespace App\Http\Controllers\Admin\DistributedOrder;

use App\Http\Controllers\Controller;
use App\Http\Requests\DisputeOrderRequest;
use App\Http\Requests\OrderDistributionRiderRequest;
use App\Models\DistributionOtp;
use App\Models\OrderDistribution;
use App\Models\OrderDistributionPharmacy;
use App\Models\OrderDistributionRider;
use App\Models\Pharmacy;
use App\Models\Rider;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Traits\TransformOrderItemTrait;


class DistributedOrderController extends Controller
{
    use TransformOrderItemTrait;

    public function __construct()
    {
        return $this->middleware('admin');
    }

    // public function index($status): View
    // {
    //     // $data['pp_count'] = false;
    //     // if ($this->getStatus($status) == 0 || $this->getStatus($status) == 1) {
    //     //     $data['pp_count'] = true;
    //     // }
    //     // $data['status'] = $status;
    //     // $data['statusBg'] = $this->statusBg($this->getStatus($status));

    //     // $data['dos'] = OrderDistribution::with(['order.products', 'odps'])
    //     //     ->withCount(['odps' => function ($query) {
    //     //         $query->where('status', '!=', -1);
    //     //     }])
    //     //     ->where('status', $this->getStatus($status))->latest()->get()
    //     //     ->each(function (&$do) {
    //     //         $this->calculateOrderTotalDiscountPrice($do->order);
    //     //     });
    //     // return view('admin.order_management.distributed_order.index', $data);
    // }
    // public function dispute($status): View
    // {
    //     $data['pp_count'] = true;
    //     $data['status'] = $status;
    //     $data['statusBg'] = $this->statusBg($this->getStatus($status));
    //     $data['dos'] = OrderDistribution::with(['order', 'odps'])
    //         ->withCount(['odps' => function ($query) {
    //             $query->where('status', '!=', -1);
    //         }])
    //         ->get()
    //         ->each(function (&$do) {
    //             $this->calculateOrderTotalPrice($do->order);
    //         })->filter(function ($do) {
    //             return $do->odps->where('status', 3)->isNotEmpty();
    //         });
    //     return view('admin.order_management.distributed_order.index', $data);
    // }

    // public function details($do_id): View
    // {
    //     $query = OrderDistribution::with(['order.customer', 'odrs.rider', 'odps' => function ($query) {
    //         $query->with('order_product.product')->where('status', '!=', -1);
    //     }])
    //         ->withCount(['odps' => function ($query) {
    //             $query->where('status', '!=', -1);
    //         }])
    //         ->findOrFail(decrypt($do_id));
    //     $query->odps->each(function (&$odp) {
    //         $odp->totalDiscountPrice = $this->OrderItemDiscountPrice($odp->order_product);
    //         $odp->totalPrice = $this->OrderItemPrice($odp->order_product);
    //     });

    //     $data['do'] = $query;
    //     $this->calculateOrderTotalDiscountPrice($query->order);
    //     if ($query->status == 2) {
    //         $data['riders'] = Rider::activated()->kycVerified()->latest()->get();
    //     }
    //     $data['pharmacies'] = Pharmacy::activated()->kycVerified()->latest()->get();
    //     if ($query->odrs) {
    //         $data['do_rider'] = $query->odrs->where('status', '!=', 0)->where('status', '!=', -1)->first();
    //         $data['dispute_do_riders'] = $query->odrs()->where('status', '=', 0)->where('status', '=', -1)->latest()->get();
    //     }
    //     return view('admin.order_management.distributed_order.details', $data);
    // }
    // public function update(DisputeOrderRequest $req): RedirectResponse
    // {
    //     foreach ($req->datas as $data) {
    //         $old_dop = OrderDistributionPharmacy::findOrFail($data['dop_id']);
    //         if ($old_dop->pharmacy_id !== $data['pharmacy_id']) {
    //             $old_dop->status = -1;
    //             $old_dop->updater()->associate(admin());
    //             $old_dop->update();

    //             $new = new OrderDistributionPharmacy();
    //             $new->order_distribution_id = $old_dop->order_distribution_id;
    //             $new->op_id = $data['op_id'];
    //             $new->pharmacy_id = $data['pharmacy_id'];
    //             $new->creater()->associate(admin());
    //             $new->save();

    //             $PVotp = DistributionOtp::where('order_distribution_id', $old_dop->order_distribution_id)->where('otp_author_id', $old_dop->pharmacy->id)->where('otp_author_type', get_class($old_dop->pharmacy))->first();
    //             $PVotp->otp_author()->associate($new->pharmacy);
    //             $PVotp->updated_by = admin()->id;
    //             $PVotp->update();
    //         }
    //     }
    //     flash()->addSuccess('Dispute Order Updated Successfully.');
    //     return redirect()->back();
    // }


    // public function do_rider(OrderDistributionRiderRequest $req, $do_id): RedirectResponse
    // {
    //     $do_id = decrypt($do_id);
    //     OrderDistributionRider::where('status', 0)->where('order_distribution_id', $do_id)->update(['status' => -1]);
    //     $do_rider = new OrderDistributionRider();
    //     $do_rider->rider_id = $req->rider_id;
    //     $do_rider->order_distribution_id = $do_id;
    //     $do_rider->priority = $req->priority;
    //     $do_rider->instraction = $req->instraction;
    //     $do_rider->save();
    //     $do = OrderDistribution::with('order', 'odps')->findOrFail($do_id);
    //     $do->update(['status' => 3]);
    //     $do->order->update(['status' => 4]);
    //     flash()->addSuccess('Rider ' . $do_rider->rider->name . ' assigned succesfully.');
    //     return redirect()->back();
    // }
    // protected function getStatus($status)
    // {
    //     switch ($status) {
    //         case 'pending':
    //             return 0;
    //         case 'preparing':
    //             return 1;
    //         case 'waiting-for-rider':
    //             return 2;
    //         case 'waiting-for-pickup':
    //             return 3;
    //         case 'picked-up':
    //             return 4;
    //         case 'delivered':
    //             return 5;
    //         case 'finish':
    //             return 6;
    //         case 'cancel':
    //             return 7;
    //     }
    // }
    // public function statusBg($status)
    // {
    //     switch ($status) {
    //         case 0:
    //             return 'badge badge-info';
    //         case 1:
    //             return 'badge badge-warning';
    //         case 2:
    //             return 'badge bg-secondary';
    //         case 3:
    //             return 'badge badge-danger';
    //         case 4:
    //             return 'badge badge-primary';
    //         case 5:
    //             return 'badge badge-dark';
    //         case 6:
    //             return 'badge badge-success';
    //         case 7:
    //             return 'badge badge-danger';
    //     }
    // }
}