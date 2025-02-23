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
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Http\Traits\TransformOrderItemTrait;
use SebastianBergmann\Type\VoidType;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\IncomeTrait;


class OrderManagementController extends Controller
{
    use TransformOrderItemTrait, IncomeTrait;

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
                $query =  OrderDistribution::with(['order', 'odps' => function ($query) use ($pharmacy_id) {
                    $query->where('pharmacy_id', $pharmacy_id);
                }, 'odrs', 'order.products.discounts', 'order.products.pivot', 'order.products.pivot.unit'])->whereHas('odps', function ($query) use ($pharmacy_id) {
                    $query->where(function ($subQuery) {
                        $subQuery->where('status', 0)->orWhere('status', 1);
                    })->where('pharmacy_id', $pharmacy_id);
                })->where(function ($subQuery) {
                    $subQuery->where('status', 0)->orWhere('status', 1);
                });
                break;

            case 'prepared':

                $query =  OrderDistribution::with(['order', 'odps' => function ($query) use ($pharmacy_id) {
                    $query->where('pharmacy_id', $pharmacy_id);
                }, 'odrs', 'order.products.discounts', 'order.products.pivot', 'order.products.pivot.unit'])->whereHas('odps', function ($query) use ($pharmacy_id) {
                    $query->where(function ($subQuery) {
                        $subQuery->where('status', 2)->orWhere('status', 3);
                    })->where('pharmacy_id', $pharmacy_id);
                });
                break;

            default:
                break;
        }


        $data['ods'] = $query->latest()->get()->each(function (&$od) {
            $this->calculateOrderTotalDiscountPrice($od->order);
        });


        return view('pharmacy.orders.index', $data);
    }


    public function details($od_id): View
    {
        $pharmacy_id = pharmacy()->id;
        $data['do'] = OrderDistribution::with(['order', 'odr', 'odps' => function ($query) {
            $query->where('pharmacy_id', pharmacy()->id);
        }, 'odps.order_product', 'active_otps'])->findOrFail(decrypt($od_id));

        // $data['do']->update(['status' => 1]);
        // $data['otp'] = DistributionOtp::where('order_distribution_id', $data['do']->id)->where('otp_author_id', pharmacy()->id)->where('otp_author_type', get_class(pharmacy()))->first();

        //odp pending -> preparing

        $data['odps_status'] = $data['do']->odps->where('status', '!=', -1)->pluck('status')->max();
        $this->updateODPStatus($data['do'], $pharmacy_id, 1);
        $this->calculateOrderTotalDiscountPrice($data['do']->order);
        $this->calculatePharmacyTotalAmount($data['do']);


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
        return view('pharmacy.orders.details', $data);
    }

    public function update(PharmacyOrderRequest $req, $do_id): RedirectResponse
    {
        foreach ($req->data as $data) {
            $dop = OrderDistributionPharmacy::findOrFail($data['dop_id']);
            $dop->open_amount = $data['open_amount'] ?? NULL;
            $dop->status = $data['status'];
            $dop->note = $data['note'];
            $dop->updated_at = Carbon::now();
            $dop->save();
        }

        //Update OD & order status if everything is prepared
        $od = OrderDistribution::with(['odps', 'order'])->findOrFail(decrypt($do_id));

        if ($od->odps->filter(function ($odp) {
            return $odp->status == 0 || $odp->status == 1;
        })->isEmpty()) {
            DB::transaction(function () use ($od) {
                $od->status = 2;
                $od->pharmacy_preped_at = Carbon::now();
                $od->save();

                $od->order->status = 3;
                $od->order->save();
            });
        }

        flash()->addSuccess('Order prepared successfully.');
        return redirect()->route('pharmacy.order_management.index', 'prepared');
    }
    protected function updateODPStatus($od, $pharmacy_id, $status): Void
    {
        foreach ($od->odps->where('pharmacy_id', $pharmacy_id)->where('status', 0) as $key => $odp) {
            $odp->status = $status;
            $odp->save();
        }
    }

    public function verify(Request $request): RedirectResponse
    {
        $od = OrderDistribution::with(['odps', 'order'])->findOrFail($request->od);
        $otp = $od->active_otps->where('pharmacy_id', pharmacy()->id)->first();
        $reqOtp = implode('', $request->otp);

        if (!empty($otp) && $otp->otp == $reqOtp) {

            $odps = OrderDistributionPharmacy::where('order_distribution_id', $od->id)->where('pharmacy_id', pharmacy()->id)->where('status', 2);

            DB::transaction(function () use ($od, $otp, $odps) {
                $odps->update(['status' => 3, 'updated_at' => Carbon::now()]); // pharmacy delivered
                $od->load(['odps', 'order']);
                if ($od->odps->filter(function ($odp) {
                    return $odp->status == 2;
                })->isEmpty()) {
                    $od->rider_collected_at = Carbon::now();
                    $od->status = 4; // rider picked up
                    $od->save();

                    $od->order->status = 5; //picked up
                    $od->order->save();

                    if ($od->assignedRider) {
                        $assignedRider = $od->assignedRider->first();
                        if ($assignedRider) {
                            $assignedRider->status = 2; // picked up
                            $assignedRider->save();
                        }
                    }
                }
                $otp->status = 2; //verified
                $otp->save();
                $this->calculatePharmacyTotalAmount($od);
                $this->addIncome(pharmacy(), $od->totalPharmacyAmount, 'tk', $od->order->id);

                flash()->addSuccess('Order delivered successfully.');
            });
        } else {
            flash()->addError('Something went wrong. Please try again');
        }

        return redirect()->back();
    }
}