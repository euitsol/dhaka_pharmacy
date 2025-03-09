<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class PaymentObserver
{
    public function saving(Payment $payment): void
    {
        $payment->load('order');
        Log::info("Payment: $payment->status");
        if ($payment->status == Payment::STATUS_PAID) {
            Log::info( "Created: paid");
            $payment->order->update(['payment_status' => Order::PAYMENT_PAID]);
        } elseif ($payment->payment_method == 'cod') {
            Log::info( "Created: cod");
            $payment->order->update(['payment_status' => Order::PAYMENT_COD]);
        } else {
            Log::info( "Created: unpaid");
            $payment->order->update(['payment_status' => Order::PAYMENT_UNPAID]);
        }

    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updating(Payment $payment): void
    {
        $payment->load('order');
        Log::info("Payment: $payment->status");
        if ($payment->status == Payment::STATUS_PAID) {
            Log::info( "Updated: paid");
            $payment->order->update(['payment_status' => Order::PAYMENT_PAID]);
        } elseif ($payment->payment_method == 'cod') {
            Log::info( "Updated: cod");
            $payment->order->update(['payment_status' => Order::PAYMENT_COD]);
        } else {
            Log::info( "Updated: unpaid");
            $payment->order->update(['payment_status' => Order::PAYMENT_UNPAID]);
        }
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
