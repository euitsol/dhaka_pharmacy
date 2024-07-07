<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Requests\PharmacyOrderRequest;
use App\Models\DistributionOtp;
use App\Models\OrderDistribution;
use App\Models\OrderDistributionPharmacy;
use App\Models\OrderDistributionRider;
use App\Models\Pharmacy;
use App\Models\PharmacyDiscount;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Traits\TransformOrderItemTrait;
use SebastianBergmann\Type\VoidType;


class OrderManagementController extends Controller
{
    use TransformOrderItemTrait;

    public function __construct()
    {
        return $this->middleware('pharmacy');
    }

    public function index($status): View
    {
        $data['status'] = $status;
        $pharmacy_id = pharmacy()->id;


        switch ($status) {
            case 'assigned':
                $query =  OrderDistribution::with(['order', 'odps', 'odrs', 'order.products.discounts', 'order.products.pivot','order.products.pivot.unit'])->whereHas('odps', function ($query) use($pharmacy_id) {
                            $query->where(function ($subQuery) {
                                $subQuery->where('status', 0)->orWhere('status', 1);
                            })->where('pharmacy_id', $pharmacy_id);
                        });
                break;

            case 'prepared':

                $query =  OrderDistribution::with(['order', 'odps', 'odrs', 'order.products.discounts', 'order.products.pivot','order.products.pivot.unit'])->whereHas('odps', function ($query) use($pharmacy_id) {
                    $query->where('pharmacy_id', $pharmacy_id);
                })->where('status', 2);
                break;

            default:
                break;
        }


        $data['ods'] = $query->get()->each(function(&$od){
            $this->calculateOrderTotalDiscountPrice($od->order);
        });

        return view('pharmacy.orders.index', $data);
    }

    public function details($od_id): View
    {

        $pharmacy_id = pharmacy()->id;



        $data['do'] = OrderDistribution::with(['order', 'odr', 'odps' => function ($query) {
                $query->where('pharmacy_id', pharmacy()->id);
            }])->findOrFail(decrypt($od_id));

        //odp pending -> preparing
        $this->updateODPStatus($data['do'], $pharmacy_id, 1);


        // $data['prep_time'] = false;
        // if ($this->getStatus($status) == 0 || $this->getStatus($status) == 1) {
        //     $data['prep_time'] = true;
        // }
        // $data['pharmacy_discount'] = PharmacyDiscount::activated()->where('pharmacy_id', pharmacy()->id)->first();

        // $data['do'] = OrderDistribution::with(['order', 'odr', 'odps' => function ($query) use ($status) {
        //     $query->with('order_product')->where('status', $this->getStatus($status));
        //     if ($this->getStatus($status) == 3) {
        //         $query->orWhere('status', -1);
        //     }
        // }])->findOrFail(decrypt($do_id));
        // if ($data['do']->status == 0) {
        //     if ($data['do']->odps->where('pharmacy_id', pharmacy()->id)->every(fn ($odp) => $odp->status == 0)) {
        //         $data['do']->odps->where('pharmacy_id', pharmacy()->id)->each(function ($odp) {
        //             $odp->update(['status' => 1]);
        //         });
        //         $data['do']->update(['status' => 1]);
        //     }
        // }
        // $data['do']->prep_time = readablePrepTime($data['do']->created_at, $data['do']->prep_time);
        // $data['do']->pharmacy = Pharmacy::findOrFail(pharmacy()->id);
        // $data['do']['dops'] = $data['do']->odps
        //     ->where('pharmacy_id', pharmacy()->id)->each(function ($dop) use ($data) {
        //         $dop->totalPrice = $this->OrderItemDiscountPrice($dop->order_product);
        //         if ($data['do']->payment_type == 0 && $data['pharmacy_discount']) {
        //             $dop->totalPrice -= (($dop->totalPrice / 100) * $data['pharmacy_discount']->discount_percent);
        //             $dop->discount = $data['pharmacy_discount']->discount_percent;
        //         }
        //         return $dop;
        //     });
        //
        // $data['statusTitle'] = $this->statusTitle($this->getStatus($status));
        // $data['statusBg'] = $this->statusBg($this->getStatus($status));
        // $data['odr'] = $data['do']->odr->first();

        // $data['otp'] = DistributionOtp::where('order_distribution_id', $data['do']->id)->where('otp_author_id', pharmacy()->id)->where('otp_author_type', get_class(pharmacy()))->first();


        return view('pharmacy.orders.details', $data);
    }

    public function update(PharmacyOrderRequest $req, $do_id): RedirectResponse
    {
        foreach ($req->data as $data) {
            $dop = OrderDistributionPharmacy::findOrFail($data['dop_id']);
            $dop->open_amount = $data['dop_id'];
            $dop->status = $data['status'];
            $dop->note = $data['note'];
            $dop->save();
        }

        //Update OD status if everything is prepared
        $od = OrderDistribution::with(['odps'])->findOrFail(decrypt($do_id));
        if($od->odps->where('status', '!=', '2')->count() == 0){
            $od->status = 2;
            $od->save();
        }

        flash()->addSuccess('Order prepared successfully.');
        return redirect()->route('pharmacy.order_management.index', 'prepared');
    }

    protected function getStatus($status)
    {
        switch ($status) {
            case 'pending':
                return 0;
            case 'preparing':
                return 1;
            case 'waiting-for-rider':
                return 2;
            case 'dispute':
                return 3;
            case 'picked-up':
                return 4;
            case 'delivered':
                return 5;
            case 'cancel':
                return 6;
            case 'old-disputed':
                return -1;
        }
    }
    public function statusBg($status)
    {
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
                return 'badge badge-dark';
            case 5:
                return 'badge badge-success';
            case 6:
                return 'badge badge-danger';
        }
    }
    public function statusTitle($status)
    {
        switch ($status) {
            case 0:
                return 'pending';
            case 1:
                return 'preparing';
            case 2:
                return 'waiting-for-rider';
            case 3:
                break;
            case -1:
                return 'dispute';
            case 4:
                return 'picked-up';
            case 5:
                return 'delivered';
            case 6:
                return 'cancel';
        }
    }

    protected function updateODPStatus($od, $pharmacy_id, $status): Void
    {
        foreach ($od->odps as $key => $odp) {
            $odp->status = $status;
            $odp->save();
        }

    }
}
