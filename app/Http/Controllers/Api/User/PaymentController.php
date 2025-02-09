<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\PaymentRequest;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class PaymentController extends BaseController
{
    public function list(Request $request): JsonResponse
    {

        $query = Payment::select(['id','order_id', 'customer_id', 'customer_type', 'status', 'amount', 'payment_method', 'transaction_id', 'created_at'])
        ->with([
            'customer:id,name,phone',
            'order:id,order_id,status,delivery_fee,sub_total,voucher_discount,product_discount,total_amount,created_at',
            ])
        ->where([
            'customer_id' => $request->user()->id,
            'customer_type' => get_class($request->user())
        ]);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $pagination = $query->paginate($request->get('per_page', 10))->withQueryString();

        $payments =  $query->latest()->get();

        $additional = [
            'current_page' => $pagination->currentPage(),
            'last_page' => $pagination->lastPage(),
            'per_page' => $pagination->perPage(),
            'total' => $pagination->total(),
            'next_page_url' => $pagination->nextPageUrl(),
            'prev_page_url' => $pagination->previousPageUrl()
        ];

        return sendResponse(true, 'Payment list retrived successfully', ['payments' => $payments], 200, $additional);
    }
    public function details(PaymentRequest $request): JsonResponse
    {
        $payment = Payment::select(['id','order_id', 'customer_id', 'customer_type', 'status', 'amount', 'payment_method', 'transaction_id', 'created_at'])
        ->with([
            'customer:id,name,phone',
            'order:id,order_id,status',
            'order.address:id,name,phone,city,street_address,latitude,longitude,apartment,floor,delivery_instruction,address',
            ])->where('transaction_id', $request->validated('transaction_id'))->first();
        return sendResponse(true, 'Payment details retrived successfully', ['payment' => $payment]);
    }
}
