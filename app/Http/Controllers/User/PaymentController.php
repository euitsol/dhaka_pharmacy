<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\TransformOrderItemTrait;
use App\Http\Traits\TransformProductTrait;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class PaymentController extends Controller
{
    use TransformOrderItemTrait, TransformProductTrait;


    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function payment_list(Request $request)
    {
        $data['pageNumber'] = $request->query('page', 1);
        $filter_val = $request->get('filter') ?? request('filter');
        $data['filterValue'] = $filter_val;
        $perPage = 10;

        $query = Payment::where([
            ['customer_id', user()->id],
            ['customer_type', get_class(user())]
        ])->latest();

        $query->with(['customer', 'order.od', 'order.ref_user']);
        if ($filter_val && $filter_val != 'all') {
            if ($filter_val == 5) {
                $query->latest();
                $perPage = 5;
            } else {
                $query->where('created_at', '>=', Carbon::now()->subDays($filter_val));
            }
        }
        $payments =  $query->paginate($perPage)->withQueryString();
        $payments->getCollection()->each(function ($payment) {
            $payment->date = date('d M Y h:m:s', strtotime($payment->created_at));
            return $payment;
        });

        $data['payments'] = $payments;
        $data['pagination'] = $payments->links('vendor.pagination.bootstrap-5')->render();
        if (request()->ajax()) {
            return response()->json($data);
        } else {
            return view('user.payment.payment_list', $data);
        }
    }
}
