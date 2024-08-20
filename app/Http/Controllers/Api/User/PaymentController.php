<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
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
        $user = $request->user();
        $filter_val = $request->filter ?? 7;

        $query = Payment::with(['customer', 'order.od'])->where([
            ['customer_id', $user->id],
            ['customer_type', get_class($user)]
        ]);

        if ($filter_val != 'all') {
            $query->where('created_at', '>=', Carbon::now()->subDays($filter_val));
        }
        $payments =  $query->latest()->get();
        return sendResponse(true, 'Payment list retrived successfully', ['payments' => $payments]);
    }
    public function details(Request $request): JsonResponse
    {
        $id = $request->id;
        $payment = Payment::with(['customer', 'order.address'])->findOrFail($id);
        $payment->place_date = date('M d,Y', strtotime($payment->created_at));
        $payment->order->place_date = date('M d,Y', strtotime($payment->order->created_at));
        if ($payment) {
            return sendResponse(true, 'Payment details retrived successfully', ['payment' => $payment]);
        } else {
            return sendResponse(false, 'Something went wrong, please try again');
        }
    }
}
