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
        return match (strtolower($status)) {
            'initiated' => 'Assigned',
            'submitted' => 'Collecting',
            'hub_assigned' => 'Assigned',
            'processing' => 'Preparing',
            'delivered' => 'Delivered',
            'returned' => 'Returned',
            default => throw new \InvalidArgumentException("Invalid status: $status"),
        };
    }
    
    public function resolveStatusBg(string $status): string
    {
        return match (strtolower($status)) {
            'initiated' => 'bg-warning',
            'submitted' => 'bg-info',
            'hub_assigned' => 'bg-warning',
            'processing' => 'bg-success',
            'delivered' => 'bg-success',
            'returned' => 'bg-danger',
            default => throw new \InvalidArgumentException("Invalid status: $status"),
        };
    }
}
