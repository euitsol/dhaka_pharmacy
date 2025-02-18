<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderHub;
use App\Models\OrderHubProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderManagementService
{
    private Order $order;

    public function setOrder(Order $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function resolveStatus(string $status): int
    {
        $status = strtolower($status);
        return match ($status) {
            'initiated' => Order::INITIATED,
            'submitted' => Order::SUBMITTED,
            'hub_assigned' => Order::HUB_ASSIGNED,
            'items_collecting' => Order::ITEMS_COLLECTING,
            'hub_reassigned' => Order::HUB_REASSIGNED,
            'items_collected' => Order::ITEMS_COLLECTED,
            'package_prepared' => Order::PACHAGE_PREPARED,
            'dispatched' => Order::DISPATCHED,
            'delivered' => Order::DELIVERED,
            'cancelled' => Order::CANCELLED,
            'returned' => Order::RETURNED,
            default => throw new \InvalidArgumentException("Invalid status: $status"),
        };
    }

    public function resolveStatusBgColor(string $status): string
    {
        return match ($status) {
            'initiated' => 'bg-warning',
            'submitted' => 'bg-success',
            'hub_assigned' => 'bg-info',
            'items_collecting' => 'bg-info',
            'hub_reassigned' => 'bg-info',
            'items_collected' => 'bg-info',
            'package_prepared' => 'bg-info',
            'dispatched' => 'bg-info',
            'delivered' => 'bg-info',
            'cancelled' => 'bg-danger',
            'returned' => 'bg-danger',
            default => 'bg-secondary',
        };
    }


    private function getUniqueHubIds(array $data): array
    {
        $hubIds = [];

        if (!isset($data['data']) || !is_array($data['data'])) {
            return [];
        }

        foreach ($data['data'] as $item) {
            if (is_array($item) && isset($item['hub_id'])) {
                $hubIds[] = $item['hub_id'];
            }
        }

        return array_unique($hubIds);
    }
}
