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

class OrderManagementService
{
    private Order $order;
    private OrderTimelineService $orderTimelineService;

    public function __construct(OrderTimelineService $orderTimelineService)
    {
        $this->orderTimelineService = $orderTimelineService;
    }

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

    public function assignOrderToHub(array $data): void
    {
        $this->validateHubAssignmentData($data);

        DB::transaction(function () use ($data) {
            $orderHubs = $this->processHubAssignments($data);
            $hubProducts = $this->mapProductsToHubs($data, $orderHubs);
            $this->saveHubProductMappings($hubProducts);
            $this->markHubAssigned();
        });
    }

    private function validateHubAssignmentData(array $data): void
    {
        $this->validateOrder();

        if (empty($data['data']) || !is_array($data['data'])) {
            throw new \InvalidArgumentException('Invalid product-hub mapping data');
        }
    }

    private function validateOrder(): void
    {
        if (!$this->order->exists) {
            throw new \RuntimeException('Order must be set before assignment');
        }
    }

    private function processHubAssignments(array $data): Collection
    {
        return collect($this->getUniqueHubIds($data))
            ->map(fn($hubId) => OrderHub::updateOrCreate(
                ['order_id' => $this->order->id, 'hub_id' => $hubId],
                ['note' => $data['note'] ?? null, 'status' => OrderHub::ASSIGNED]
            ));
    }

    private function mapProductsToHubs(array $data, Collection $orderHubs): array
    {
        return collect($data['data'])
            ->map(function ($item) use ($orderHubs) {
                $orderProduct = OrderProduct::where('order_id', $this->order->id)
                    ->where('product_id', $item['p_id'])
                    ->firstOrFail();

                return [
                    'order_hub_id' => $orderHubs->firstWhere('hub_id', $item['hub_id'])->id,
                    'order_product_id' => $orderProduct->id,
                    'status' => OrderHubProduct::ACTIVE
                ];
            })
            ->all();
    }

    private function saveHubProductMappings(array $hubProducts): void
    {
        OrderHubProduct::upsert(
            $hubProducts,
            ['order_hub_id', 'order_product_id'],
            ['status', 'updated_at']
        );
    }

    public function updateOrderStatus(int $newStatus): void
    {
        $this->validateOrder();
        DB::transaction(function () use ($newStatus) {
            $previousStatus = $this->order->status;

            $this->order->update(['status' => $newStatus]);

            $this->orderTimelineService->updateTimelineStatus(
                $this->order,
                $newStatus
            );
        });
    }


    public function markHubAssigned(): void
    {
        $this->updateOrderStatus(Order::HUB_ASSIGNED);
    }

    public function markItemsCollecting(): void
    {
        $this->updateOrderStatus(Order::ITEMS_COLLECTING);
    }

    public function markItemsCollected(): void
    {
        $this->updateOrderStatus(Order::ITEMS_COLLECTED);
    }

    public function markPackagePrepared(): void
    {
        $this->updateOrderStatus(Order::PACHAGE_PREPARED);
    }

    public function markDispatched(): void
    {
        $this->updateOrderStatus(Order::DISPATCHED);
    }

    public function markDelivered(): void
    {
        $this->updateOrderStatus(Order::DELIVERED);
    }
}
