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


class OrderManagementController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('admin');
    }
    public function index($status): View
    {
        
        $data['orders'] = Order::status($status)->latest()->get()
                        ->map(function ($order) {
                            $order->totalPrice = AddToCart::with('product')
                                ->whereIn('id', json_decode($order->carts))
                                ->get()
                                ->sum(function ($item) {
                                    return (($item->product->discountPrice() * ($item->unit->quantity ?? 1)) * $item->quantity);
                                });
                            return $order;
                        });
        $data['status'] = ucfirst($status);
        $data['statusBgColor'] = $this->getOrderStatusBgColor($status);
        return view('admin.order_management.index',$data);
    }
    public function details($id): View
    {
        $data['order'] = Order::findOrFail(decrypt($id));
        $data['order_items'] = AddToCart::with(['product.pro_cat', 'product.pro_sub_cat', 'product.generic', 'product.company', 'product.strength', 'customer', 'unit'])
                            ->whereIn('id', json_decode($data['order']->carts))
                            ->get();
        
        $data['order_items']->transform(function($item) {
            $item->price = (($item->product->price*($item->unit->quantity ?? 1))*$item->quantity);
            $item->discount_price = (($item->product->discountPrice()*($item->unit->quantity ?? 1))*$item->quantity);
            $item->discount = (productDiscountAmount($item->product->id)*($item->unit->quantity ?? 1))*$item->quantity;
            return $item;
        });
        
        $data['totalPrice'] = $data['order_items']->sum('discount_price');
        $data['totalRegularPrice'] = $data['order_items']->sum('price');
        $data['totalDiscount'] = $data['order_items']->sum('discount');
        return view('admin.order_management.details',$data);
    }

    public function order_distribution($id){
        $data['order'] = Order::with('address')->findOrFail(decrypt($id));
        $data['order_items'] = AddToCart::with(['product.pro_cat', 'product.pro_sub_cat', 'product.generic', 'product.company', 'product.strength', 'customer', 'unit'])
                            ->whereIn('id', json_decode($data['order']->carts))
                            ->get();
        $data['order_items']->transform(function($item) {
            $item->price = (($item->product->price*($item->unit->quantity ?? 1))*$item->quantity);
            $item->discount_price = (($item->product->discountPrice()*($item->unit->quantity ?? 1))*$item->quantity);
            $item->discount = (productDiscountAmount($item->product->id)*($item->unit->quantity ?? 1))*$item->quantity;
            return $item;
        });
        
        $data['totalPrice'] = $data['order_items']->sum('discount_price');
        $data['totalRegularPrice'] = $data['order_items']->sum('price');
        $data['totalDiscount'] = $data['order_items']->sum('discount');
        $data['pharmacies'] = Pharmacy::activated()->kycVerified()->latest()->get();
        $data['order_distribution'] = OrderDistribution::with(['odps.cart','odps.pharmacy'])->where('status',0)->where('order_id',$data['order']->id)->first();
        return view('admin.order_management.order_distribution',$data);
    }

    public function order_distribution_store(OrderDistributionRequest $req, $order_id){
        $order_id = decrypt($order_id);


        Order::findOrFail($order_id)->update(['status'=>-3]);
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
            $odp->cart_id = $data['cart_id'];
            $odp->pharmacy_id = $data['pharmacy_id'];
            $odp->creater()->associate(admin());
            $odp->save();

            $check = DistributionOtp::where('order_distribution_id',$od->id)->where('otp_author_id', $odp->pharmacy->id)->where('otp_author_type', get_class($odp->pharmacy))->first();
            if(!$check){
                $PVotp = new DistributionOtp();
                $PVotp->order_distribution_id = $od->id;
                $PVotp->otp_author()->associate($odp->pharmacy);
                $PVotp->otp = otp();
                $PVotp->created_by = admin()->id;
                $PVotp->save();
            }
        }
        flash()->addSuccess('Order Distributed Successfully.');
        return redirect()->route('om.order.order_list','pending'); 
    }

   
    protected function getOrderStatusBgColor($status){
        $statusBgColor = ($status == 'success') ? 'badge badge-success' : (($status == 'pending') ? 'badge badge-info' : (($status == 'failed') ? 'badge badge-danger' : (($status == 'cancel') ? 'badge badge-warning' : 'badge badge-primary')));
        return $statusBgColor;
    }


    
}
