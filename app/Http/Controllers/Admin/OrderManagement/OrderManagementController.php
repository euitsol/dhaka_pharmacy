<?php

namespace App\Http\Controllers\Admin\OrderManagement;

use App\Events\OrderStatusChangeEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\DisputeOrderRequest;
use App\Http\Requests\OrderDistributionRequest;
use App\Http\Requests\OrderDistributionRiderRequest;
use App\Http\Traits\DeliveryTrait;
use App\Http\Traits\OTPTrait;
use App\Models\AddToCart;
use App\Models\DistributionOtp;
use App\Models\Order;
use App\Models\OrderDistribution;
use App\Models\OrderDistributionPharmacy;
use App\Models\Payment;
use App\Models\Pharmacy;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Traits\TransformOrderItemTrait;
use App\Models\OrderDistributionRider;
use App\Models\Rider;

class OrderManagementController extends Controller
{
    use TransformOrderItemTrait, OTPTrait, DeliveryTrait;

    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index($status): View|RedirectResponse
    {
        $data['status'] = ucfirst($status);
        $data['statusBgColor'] = $this->getOrderStatusBgColor($status);
        switch ($status) {
            case 'initiated':
                $data['orders'] = Order::with('products', 'products.units', 'products.discounts', 'products.pivot.unit', 'od')->status($status)->latest()->get()
                    ->each(
                        function (&$order) {
                            $this->calculateOrderTotalDiscountPrice($order);
                        }
                    );
                return view('admin.order_management.index', $data);
            case 'submitted':
                $data['orders'] = Order::with('products', 'products.units', 'products.discounts', 'products.pivot.unit', 'od',)->status($status)->latest()->get()
                    ->each(
                        function (&$order) {
                            $this->calculateOrderTotalDiscountPrice($order);
                        }
                    );
                return view('admin.order_management.index', $data);
            case 'processed':
                $data['dos'] = OrderDistribution::with(['order.products', 'odps', 'creater'])
                    ->withCount(['odps' => function ($query) {
                        $query->where('status', '!=', -1);
                    }])
                    ->where('status', 1)
                    ->orWhere('status', 0)
                    ->latest()->get()
                    ->each(function (&$do) {
                        $this->calculateOrderTotalDiscountPrice($do->order);
                    });
                return view('admin.order_management.distributed_order.index', $data);
            case 'waiting-for-rider':
                $data['dos'] = OrderDistribution::with(['order', 'order.products', 'order.products.units', 'order.products.discounts', 'order.products.pivot.unit', 'odps', 'creater'])
                    ->withCount(['odps' => function ($query) {
                        $query->where('status', '!=', -1);
                    }])
                    ->whereHas('order', function ($query) {
                        $query->where('status', 3);
                    })
                    ->where('status', 2)
                    ->latest()->get()
                    ->each(function (&$do) {
                        $this->calculateOrderTotalDiscountPrice($do->order);
                    });
                return view('admin.order_management.distributed_order.index', $data);
            case 'assigned':
                $data['dos'] = OrderDistribution::with(['order', 'order.products', 'order.products.units', 'order.products.discounts', 'order.products.pivot.unit', 'assignedRider', 'assignedRider.rider', 'creater'])
                    ->withCount(['odps' => function ($query) {
                        $query->where('status', '!=', -1);
                    }])
                    ->whereHas('order', function ($query) {
                        $query->whereIn('status', [4, 5]);
                    })
                    ->latest()->get()
                    ->each(function (&$do) {
                        $this->calculateOrderTotalDiscountPrice($do->order);
                    });
                return view('admin.order_management.distributed_order.index', $data);
            case 'delivered':
                $data['dos'] = OrderDistribution::with(['order', 'order.products', 'order.products.units', 'order.products.discounts', 'order.products.pivot.unit', 'assignedRider', 'assignedRider.rider', 'creater'])
                    ->withCount(['odps' => function ($query) {
                        $query->where('status', '!=', -1);
                    }])
                    ->whereHas('order', function ($query) {
                        $query->where('status', 6);
                    })
                    ->latest()->get()
                    ->each(function (&$do) {
                        $this->calculateOrderTotalDiscountPrice($do->order);
                    });
                return view('admin.order_management.distributed_order.index', $data);
            default:
                flash()->addError('Something went wrong');
                return redirect()->back();
        }
    }
    public function details($id): View
    {
        $data['order'] = Order::with('products', 'products.units', 'products.discounts', 'products.pivot.unit')->findOrFail(decrypt($id));
        $this->calculateOrderTotalPrice($data['order']);
        $this->calculateOrderTotalDiscountPrice($data['order']);
        return view('admin.order_management.details', $data);
    }

    public function order_distribution($id)
    {
        $data['order'] = Order::with(['address', 'od.odps.order_product', 'od.odps.pharmacy', 'products', 'products.pivot.unit', 'payments'])->paid()->find(decrypt($id));
        if (!empty($data['order'])) {
            $data['pharmacies'] = Pharmacy::with(['operation_area', 'operation_sub_area', 'address'])->activated()->kycVerified()->latest()->get()->reject(function ($pharmacy) use ($data) {
                $pharmacy->area = getPharmacyArea($pharmacy);
                $pharmacy->sub_area = getPharmacySubArea($pharmacy);
                if ($pharmacy->address) {
                    $pharmacy->distance = $this->calculateDistance(
                        $pharmacy->address->latitude,
                        $pharmacy->address->longitude,
                        $data['order']->address->latitude,
                        $data['order']->address->longitude
                    );
                }


                // Reject the pharmacy if the distance exceeds the configured radius
                return $pharmacy->distance > config('mapbox.pharmacy_radious');
            });
            $this->calculateOrderTotalPrice($data['order']);
            $this->calculateOrderTotalDiscountPrice($data['order']);
            return view('admin.order_management.order_distribution', $data);
        } else {
            flash()->addError('Cannot distribute this order');
            return redirect()->back();
        }
    }

    public function order_distribution_store(OrderDistributionRequest $req, $order_id): RedirectResponse
    {
        $order_id = decrypt($order_id);
        $order = Order::findOrFail($order_id);

        if ($order->status == 1) {
            //Update order status to distributed
            $order->status = 2;
            $order->save();

            //Create new order distribution
            $od = new OrderDistribution();
            $od->order_id = $order_id;
            $od->payment_type = $req->payment_type;
            $od->distribution_type = $req->distribution_type;

            //prepare the time
            $od->pharmacy_prep_time = Carbon::now()->addMinutes($req->prep_time)->toDateTimeString();

            $od->note = $req->note;
            $od->creater()->associate(admin());
            $od->save();

            // Iterate through the datas and create OrderDistributionPharmacy entries
            foreach ($req->datas as $data) {
                $odp = new OrderDistributionPharmacy();
                $odp->order_distribution_id = $od->id;
                $odp->op_id = $data['op_id'];
                $odp->pharmacy_id = $data['pharmacy_id'];
                $odp->creater()->associate(admin());
                $odp->save();

                // $this->createDistributionOTP($od, $odp);
            }



            flash()->addSuccess('Order Processed Successfully.');
            return redirect()->route('om.order.order_list', 'processed');
        } else {
            flash()->addSuccess('Cannot process this order');
            return redirect()->route('om.order.order_list', 'submitted');
        }
    }


    public function distribution_details($do_id): View
    {
        // $query = OrderDistribution::with(['order.customer', 'odrs.rider', 'odps' => function ($query) {
        //     $query->with('order_product.product')->where('status', '!=', -1);
        // }])
        //     ->withCount(['odps' => function ($query) {
        //         $query->where('status', '!=', -1);
        //     }])
        //     ->findOrFail(decrypt($do_id));

        // $query->odps->each(function (&$odp) {
        //     $odp->totalDiscountPrice = $this->OrderItemDiscountPrice($odp->order_product);
        //     $odp->totalPrice = $this->OrderItemPrice($odp->order_product);
        // });
        // $this->calculateOrderTotalDiscountPrice($query->order);
        // if ($query->status == 2) {
        //     $data['riders'] = Rider::activated()->kycVerified()->latest()->get();
        // }
        // $data['pharmacies'] = Pharmacy::activated()->kycVerified()->latest()->get();
        // if ($query->odrs) {
        //     $data['assigned_rider'] = $query->odrs->where('status', '!=', 0)->where('status', '!=', -1)->first();
        //     $data['dispute_riders'] = $query->odrs()->where('status', 0)->orWhere('status', -1)->latest()->get();
        // }
        // $data['do'] = $query;

        $data['do'] = OrderDistribution::with([
            'assignedRider',
            'disputedRiders',
            'order.customer',
            'order.products',
            'order.products.units',
            'order.products.discounts',
            'order.products.pivot.unit',
            'odrs',
            'odps',
            'order'
        ])
            ->findOrFail(decrypt($do_id));


        $this->calculateOrderTotalDiscountPrice($data['do']->order);
        switch ($data['do']->status) {
            case 1:
                break;
            case 2:
                $data['riders'] = Rider::activated()->kycVerified()->latest()->get();
                break;
            case 3:
                $data['riders'] = Rider::activated()->kycVerified()->latest()->get();
                break;

            default:
                break;
        }

        $data['pharmacies'] = Pharmacy::with(['operation_area', 'operation_sub_area', 'address'])->activated()->kycVerified()->latest()->get()->reject(function ($pharmacy) use ($data) {
            $pharmacy->area = getPharmacyArea($pharmacy);
            $pharmacy->sub_area = getPharmacySubArea($pharmacy);
            if ($pharmacy->address) {
                $pharmacy->distance = $this->calculateDistance(
                    $pharmacy->address->latitude,
                    $pharmacy->address->longitude,
                    $data['do']->order->address->latitude,
                    $data['do']->order->address->longitude
                );
            }
        });


        return view('admin.order_management.distributed_order.details', $data);
    }

    public function assign_order(OrderDistributionRiderRequest $req, $do_id): RedirectResponse
    {
        $interval_time = 5; //minutes to collect the order

        $do_id = decrypt($do_id);

        OrderDistributionRider::where('status', 0)->where('order_distribution_id', $do_id)->update(['status' => -1]);

        $do_rider = new OrderDistributionRider();
        $do_rider->rider_id = $req->rider_id;
        $do_rider->order_distribution_id = $do_id;
        $do_rider->priority = $req->priority;
        $do_rider->instraction = $req->instraction;
        $do_rider->creater()->associate(admin());
        $do_rider->save();

        $do = OrderDistribution::with('order')->findOrFail($do_id);
        $do->update(['status' => 3, 'rider_collect_time' => Carbon::now()->addMinutes($req->pick_up_time)->toDateTimeString(), 'rider_delivery_time' => Carbon::now()->addMinutes($req->pick_up_time + $interval_time + $req->delivery_time)->toDateTimeString()]);
        $do->order->update(['status' => 4]);

        //Delivery OTP
        $this->generateDeliveryOtp([
            'order_distribution_id' => $do_id,
            'rider_id' => $do_rider->rider_id,
        ]);

        flash()->addSuccess('Rider ' . $do_rider->rider->name . ' assigned succesfully.');
        return redirect()->back();
    }

    public function disputeUpdate(DisputeOrderRequest $req): RedirectResponse
    {
        foreach ($req->datas as $data) {
            $old_dop = OrderDistributionPharmacy::findOrFail($data['dop_id']);
            if ($old_dop->pharmacy_id !== $data['pharmacy_id']) {
                $old_dop->status = -1;
                $old_dop->updater()->associate(admin());
                $old_dop->update();

                $new = new OrderDistributionPharmacy();
                $new->order_distribution_id = $old_dop->order_distribution_id;
                $new->op_id = $data['op_id'];
                $new->pharmacy_id = $data['pharmacy_id'];
                $new->creater()->associate(admin());
                $new->save();

                $PVotp = DistributionOtp::where('order_distribution_id', $old_dop->order_distribution_id)->where('otp_author_id', $old_dop->pharmacy->id)->where('otp_author_type', get_class($old_dop->pharmacy))->first();
                $PVotp->otp_author()->associate($new->pharmacy);
                $PVotp->updated_by = admin()->id;
                $PVotp->update();
            }
        }
        flash()->addSuccess('Dispute Order Updated Successfully.');
        return redirect()->back();
    }

    protected function getOrderStatusBgColor($status): string
    {
        // $statusBgColor = ($status == 'success') ? 'badge badge-success' : (($status == 'pending') ? 'badge badge-info' : (($status == 'failed') ? 'badge badge-danger' : (($status == 'cancel') ? 'badge badge-warning' : 'badge badge-primary')));

        switch ($status) {
            case 'initiated':
                return 'badge badge-secondary';
            case 'submitted':
                return 'badge badge-info';
            case 'processed':
                return 'badge badge-success';
            case 'waiting-for-rider':
                return 'badge badge-warning';
            case -1:
                return 'badge badge-danger';
            case -2:
                return 'badge badge-warning';
            case -3:
                return 'badge badge-dark';
            default:
                return 'badge badge-primary';
        }
    }

    protected function createDistributionOTP($od, $odp): Void
    {
        $check = DistributionOtp::where('order_distribution_id', $od->id)->where('otp_author_id', $odp->pharmacy->id)->where('otp_author_type', get_class($odp->pharmacy))->first();
        if (!$check) {
            $PVotp = new DistributionOtp();
            $PVotp->order_distribution_id = $od->id;
            $PVotp->otp_author()->associate($odp->pharmacy);
            $PVotp->otp = otp();
            $PVotp->created_by = admin()->id;
            $PVotp->save();
        }
    }
}
