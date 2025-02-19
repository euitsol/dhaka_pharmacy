<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderHub;
use App\Models\OrderHubProduct;
use App\Models\OrderProduct;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Events\OrderStatusChanged;
use App\Exceptions\InvalidStatusException;
use App\Exceptions\InvalidStatusTransitionException;
use App\Services\OrderTimelineService;

class OrderHubManagementService
{
    protected OrderHub $orderHub;
    protected OrderTimelineService $orderTimelineService;

    public function __construct(OrderTimelineService $orderTimelineService)
    {
        $this->orderTimelineService = $orderTimelineService;
    }

    public function setOrderHub(OrderHub $orderHub):self
    {
        $this->orderHub = $orderHub;
        return $this;
    }

    public function collect()
    {
        DB::beginTransaction();
        $orderHub = $this->orderHub->load('order');
        $orderHub->update(['status' => Order::ITEMS_COLLECTING]);
        $this->updateOrderStatus($orderHub->order, Order::ITEMS_COLLECTING);
        DB::commit();
    }

protected function updateOrderStatus(Order $order, $newstatus)
{
    $order->update(['status' => $newstatus]);
    $this->orderTimelineService->updateTimelineStatus(
        $order,
        $newstatus
    );
}
    public function resolveStatus(string $status): string
    {
        $status = strtolower($status);
        return match ($status) {
            'assigned' => OrderHub::ASSIGNED,
            'collecting' => OrderHub::COLLECTING,
            'collected' => OrderHub::COLLECTED,
            'prepared' => OrderHub::PREPARED,
            'shipped' => OrderHub::DISPATCHED,
            'delivered' => OrderHub::DELIVERED,
            'returned' => OrderHub::RETURNED,
            default => throw new \InvalidArgumentException("Invalid status: $status"),
        };
    }

    public function resolveStatusBg(string $status): string
    {
        return match (strtolower($status)) {
            'assigned' => 'bg-warning',
            'collecting' => 'bg-info',
            'collected' => 'bg-info',
            'prepared' => 'bg-success',
            'shipped' => 'bg-success',
            'delivered' => 'bg-success',
            'returned' => 'bg-danger',
            default => throw new \InvalidArgumentException("Invalid status: $status"),
        };
    }
}
