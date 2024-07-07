<?php

namespace App\Http\Controllers\Admin\OrderManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderDistributionRequest;
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

class OrderManagementController extends Controller
{
    use TransformOrderItemTrait;

    public function __construct()
    {
        return $this->middleware('admin');
    }
    public function index($status): View
    {
        $data['status'] = ucfirst($status);
        $data['statusBgColor'] = $this->getOrderStatusBgColor($status);



        switch ($status) {
            case 'initiated':
                $data['orders'] = Order::with('products', 'products.units', 'products.discounts', 'products.pivot.unit', 'od')->status($status)->latest()->get()
                    ->each(function (&$order) {
                        $this->calculateOrderTotalDiscountPrice($order);
                    }
                );
                return view('admin.order_management.index', $data);
            case 'submitted':
                $data['orders'] = Order::with('products', 'products.units', 'products.discounts', 'products.pivot.unit', 'od')->status($status)->latest()->get()
                    ->each(function (&$order) {
                        $this->calculateOrderTotalDiscountPrice($order);
                    }
                );
                return view('admin.order_management.index', $data);
            case 'processed':

                $data['dos'] = OrderDistribution::with(['order.products', 'odps'])
                    ->withCount(['odps' => function ($query) {
                        $query->where('status', '!=', -1);
                    }])
                    ->where('status', 1)
                    ->orWhere('status', 0)
                    ->latest()->get()
                    ->each(function (&$do) {
                        $this->calculateOrderTotalDiscountPrice($do->order);
                    });
                return view('admin.distributed_order.index', $data);

            default:
                break;
        }
    }
    public function details($id): View
    {
        $data['order'] = Order::with('products')->findOrFail(decrypt($id));
        $this->calculateOrderTotalPrice($data['order']);
        $this->calculateOrderTotalDiscountPrice($data['order']);
        return view('admin.order_management.details', $data);
    }

    public function order_distribution($id)
    {
        $data['order'] = Order::with(['address', 'od.odps.cart', 'od.odps.pharmacy', 'products', 'products.pivot.unit', 'payments'])->paid()->find(decrypt($id));
        if(!empty($data['order'])){
            $this->calculateOrderTotalPrice($data['order']);
            $this->calculateOrderTotalDiscountPrice($data['order']);

            $data['pharmacies'] = Pharmacy::activated()->kycVerified()->latest()->get();
            if ($data['order']->od) {
                $data['order_distribution'] = $data['order']->od->where('status', 0)->first();
            }
            return view('admin.order_management.order_distribution', $data);
        }else{
            flash()->addError('Cannot distribute this order');
            return redirect()->back();
        }

    }

    public function order_distribution_store(OrderDistributionRequest $req, $order_id): RedirectResponse
    {
        $order_id = decrypt($order_id);
        $order = Order::findOrFail($order_id);

        if($order->status == 1){
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

                $this->createDistributionOTP($od, $odp);
            }
            flash()->addSuccess('Order Processed Successfully.');
            return redirect()->route('om.order.order_list', 'processed');
        }else{
            flash()->addSuccess('Cannot process this order');
            return redirect()->route('om.order.order_list', 'submitted');
        }
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
