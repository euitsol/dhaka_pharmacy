<?php

namespace App\Observers;

use App\Events\OrderStatusChangeEvent;
use App\Models\Order;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\UserNotificationTrait;

class OrderModelObserver implements ShouldHandleEventsAfterCommit
{
    use UserNotificationTrait;
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void {}

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        $order = $order->load(['od', 'customer']);
        if ($order->wasChanged('status') && $order->status > 0) {
            $this->order_notification($order, 'order');
        }
        if ($order->wasChanged('status') && (isset($order->od) && !empty($order->od))) {
            event(new OrderStatusChangeEvent($order));
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
