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
use App\Models\OrderHubPharmacy;
use App\Services\OrderTimelineService;
use App\Services\OrderDeliveryService;

class OrderHubManagementService
{
    protected OrderHub $orderHub;
    protected OrderTimelineService $orderTimelineService;
    protected Order $order;
    protected OrderDeliveryService $orderDeliveryService;

    public function __construct(OrderTimelineService $orderTimelineService, OrderDeliveryService $orderDeliveryService)
    {
        $this->orderTimelineService = $orderTimelineService;
        $this->orderDeliveryService = $orderDeliveryService;
    }

    public function setOrder(Order $order):self
    {
        $this->order = $order;
        return $this;
    }

    public function setOrderHub(OrderHub $orderHub):self
    {
        $this->orderHub = $orderHub;
        return $this;
    }

    public function collecting()
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

    public function prepareOrder(array $formData)
    {
        DB::beginTransaction();
        $orderHub = OrderHub::where('order_id', $this->order->id)->ownedByHub()->get()->first();
        $this->setOrderHub($orderHub);

        $this->orderHub->update(['status' => OrderHub::PREPARED]);
        $this->updateOrderStatus($this->order, Order::PACHAGE_PREPARED);
        $this->orderTimelineService->updateTimelineStatus(
            $this->order,
            Order::PACHAGE_PREPARED
        );
        $this->createDeliveryRequest();
        DB::commit();
    }

    protected function createDeliveryRequest(string $type='steadfast')
    {
        $this->orderDeliveryService->setOrderHub($this->orderHub)->setType($type)->processDelivery();
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

    public function collectOrderItems(array $collectionData)
    {
        $this->validateOrder(Order::ITEMS_COLLECTING);
        return DB::transaction(function () use ($collectionData) {
            // Get or create OrderHub
            $orderHub = OrderHub::where('order_id', $this->order->id)->ownedByHub()->get()->first();
            if (!$orderHub->hub_id) {
                Throw new ModelNotFoundException('OrderHub not found');
            }

            $this->setOrderHub($orderHub);

            // Group collection data by pharmacy
            $pharmacyGroups = collect($collectionData['data'])->groupBy('pharmacy_id');

            foreach ($pharmacyGroups as $pharmacyId => $items) {
                $totalPayableAmount = 0;
                $pharmacyProducts = [];

                foreach ($items as $item) {
                    $orderProduct = OrderProduct::where('order_id', $this->order->id)
                        ->where('product_id', $item['p_id'])
                        ->firstOrFail();

                    $totalPayableAmount += $item['unit_payable_price'] * $orderProduct->quantity;
                    $pharmacyProducts[] = [
                        'order_product' => $orderProduct,
                        'unit_payable_price' => $item['unit_payable_price']
                    ];
                }

                $orderHubPharmacy = OrderHubPharmacy::query()->create([
                    'order_id' => $this->order->id,
                    'hub_id' => $this->orderHub->hub_id,
                    'pharmacy_id' => $pharmacyId,
                    'total_payable_amount' => $totalPayableAmount,
                    'status' => OrderHubPharmacy::COLLECTED
                ]);

                foreach ($pharmacyProducts as $product) {
                    $orderProduct = $product['order_product'];

                    $orderHubPharmacy->products()->create([
                        'order_product_id' => $orderProduct->id,
                        'unit_payable_price' => $product['unit_payable_price'],
                        'quantity_collected' => $orderProduct->quantity,
                        'status' => OrderHubProduct::ACTIVE
                    ]);
                }
            }

            $this->order->update(['status' => Order::ITEMS_COLLECTED]);
            $orderHub->update(['status' => OrderHub::COLLECTED]);

            // Create timeline entry
            $this->orderTimelineService->updateTimelineStatus($this->order, Order::ITEMS_COLLECTED);

            return $orderHub;
        });
    }

    protected function validateOrder($status=null): void
    {
        if (!$this->order instanceof Order) {
            throw new \Exception('Order not found');
        }
        if ($status && $this->order->status !== $status) {
            throw new \Exception('Order must be in correct status to process');
        }
    }
}
