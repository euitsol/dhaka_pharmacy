<?php

namespace App\Services;

use App\Models\{Order, OrderStatusRule, OrderTimeline};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Models\OrderHub; // added this line

class OrderTimelineService
{

    public function createAllTimelineEntries(Order $order): void
    {
        $rules = OrderStatusRule::orderBy('sort_order')->get();


        foreach ($rules as $rule) {
            $order->timelines()->create([
                'status'                   => $rule->status_code,
                'expected_completion_time' => $rule->getExpectedCompletionTime(),
                'actual_completion_time'   => $rule->status_code == 0 ? now() : null,
            ]);
        }
    }

    public function updateTimelineStatus(Order $order, int $currentStatus): void
    {
        $timelineEntry = $order->timelines()->where('status', $currentStatus)->first();

        if ($timelineEntry) {
            $timelineEntry->update([
                'actual_completion_time' => now()
            ]);

            Log::info($order->order_id."Timeline updated successfully".$currentStatus);
        }
    }


    public function getProcessedTimeline(Order $order,bool $onlyVisible = true): Collection
    {
        $query = $order->timelines()->select('id','order_id','status','expected_completion_time','actual_completion_time')->with('statusRule:id,status_code,status_name,sort_order,visible_to_user')->orderBy('created_at');
        $entries = $query->get();

        if ($onlyVisible) {
            $entries = $entries->filter(function ($entry) {
                return $entry->statusRule && $entry->statusRule->visible_to_user;
            });
        }

        return $entries->sortBy(function ($entry) {
            return $entry->statusRule->sort_order;
        })->values();

    }

    public function getHubProcessedTimeline(Order $order): Collection
    {
        $query = $order->timelines()->select('id','order_id','status','expected_completion_time','actual_completion_time')
            ->with('statusRule:id,status_code,status_name,sort_order')
            ->orderBy('created_at');

        return $query->get()
            ->filter(function ($entry) {
                return in_array($entry->status, [
                    Order::HUB_ASSIGNED,
                    Order::ITEMS_COLLECTING,
                    Order::ITEMS_COLLECTED,
                    Order::PACHAGE_PREPARED,
                    Order::DISPATCHED,
                    Order::DELIVERED,
                    Order::CANCELLED,
                    Order::RETURNED
                ]);
            })
            ->sortBy(function ($entry) {
                return $entry->statusRule->sort_order;
            })
            ->values();
    }
}
