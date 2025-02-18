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

class OrderHubManagementService
{

    public function resolveStatus(string $status): string
    {
        $status = strtolower($status);
        return match ($status) {
            'assigned' => OrderHub::ASSIGNED,
            'collecting' => OrderHub::COLLECTING,
            'collected' => OrderHub::COLLECTED,
            'preparing' => OrderHub::PREPARING,
            'prepared' => OrderHub::PREPARED,
            'shipped' => OrderHub::SHIPPED,
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
            'preparing' => 'bg-success',
            'prepared' => 'bg-success',
            'shipped' => 'bg-success',
            'delivered' => 'bg-success',
            'returned' => 'bg-danger',
            default => throw new \InvalidArgumentException("Invalid status: $status"),
        };
    }
}
