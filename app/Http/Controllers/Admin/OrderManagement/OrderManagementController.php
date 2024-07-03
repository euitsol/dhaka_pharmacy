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
        $data['orders'] = Order::with('products')->status($status)->latest()->get()
            ->each(function (&$order) {
                $this->calculateOrderTotalDiscountPrice($order);
            });
        $data['status'] = ucfirst($status);
        $data['statusBgColor'] = $this->getOrderStatusBgColor($status);
        return view('admin.order_management.index', $data);
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
        $data['order'] = Order::with(['address', 'od.odps.cart', 'od.odps.pharmacy', 'products'])->findOrFail(decrypt($id));
        $this->calculateOrderTotalPrice($data['order']);
        $this->calculateOrderTotalDiscountPrice($data['order']);

        $data['pharmacies'] = Pharmacy::activated()->kycVerified()->latest()->get();
        if ($data['order']->od) {
            $data['order_distribution'] = $data['order']->od->where('status', 0)->first();
        }
        return view('admin.order_management.order_distribution', $data);
    }

    public function order_distribution_store(OrderDistributionRequest $req, $order_id)
    {
        $order_id = decrypt($order_id);
        Order::findOrFail($order_id)->update(['status' => -3]);
        $od = new OrderDistribution();
        $od->order_id = $order_id;
        $od->payment_type = $req->payment_type;
        $od->distribution_type = $req->distribution_type;
        $od->prep_time = $req->prep_time;
        $od->note = $req->note;
        $od->creater()->associate(admin());
        $od->save();

        // Iterate through the datas and update or create OrderDistributionPharmacy entries
        foreach ($req->datas as $data) {
            $odp = new OrderDistributionPharmacy();
            $odp->order_distribution_id = $od->id;
            $odp->op_id = $data['op_id'];
            $odp->pharmacy_id = $data['pharmacy_id'];
            $odp->creater()->associate(admin());
            $odp->save();

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
        flash()->addSuccess('Order Distributed Successfully.');
        return redirect()->route('om.order.order_list', 'pending');
    }


    protected function getOrderStatusBgColor($status)
    {
        $statusBgColor = ($status == 'success') ? 'badge badge-success' : (($status == 'pending') ? 'badge badge-info' : (($status == 'failed') ? 'badge badge-danger' : (($status == 'cancel') ? 'badge badge-warning' : 'badge badge-primary')));
        return $statusBgColor;
    }
}
