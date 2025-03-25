<?php

namespace App\Observers;

use App\Events\OrderStatusChangeEvent;
use App\Models\Order;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\UserNotificationTrait;
use App\Models\RewardSetting;
use App\Services\RewardService;

class OrderModelObserver implements ShouldHandleEventsAfterCommit
{
    use UserNotificationTrait;
    private RewardService $rewardService;

    public function __construct(RewardService $rewardService)
    {
        $this->rewardService = $rewardService;
    }
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void {}

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        $order = $order->load(['od', 'customer', 'earnings']);
        if ($order->wasChanged('status') && $order->status > Order::INITIATED) {
            $this->order_notification($order, 'order');
        }
        if ($order->wasChanged('status') && $order->status == Order::SUBMITTED && $order->earnings->isEmpty()) {
            $this->rewardService->setOrder($order);
            if ($this->rewardService->checkRewardAbility()) {
                $this->rewardService->addRewardEarning(RewardSetting::TYPE_ORDER);
            };
        }
        if ($order->wasChanged('status') && $order->status == Order::DELIVERED) {
            $this->rewardService->setOrder($order);
            $this->rewardService->completeRewardEarning();
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
