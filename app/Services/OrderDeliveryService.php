<?php

namespace App\Services;

use App\Models\Order;
use App\Services\SteadFastService;
use App\Models\OrderHub;

class OrderDeliveryService
{
    protected SteadFastService$steadFastService;
    protected OrderHub $orderHub;

    public function __construct(SteadFastService $steadFastService)
    {
        $this->steadFastService = $steadFastService;
    }

    public function processDelivery(string $type)
    {
        $this->steadFastService->createShipment($this->orderHub);
    }

    public function validateDelivery()
    {
        if(!$this->orderHub){
            throw new \InvalidArgumentException("Order hub not found");
        }

        if(!$this->orderHub->order){
            throw new \InvalidArgumentException("Order not found");
        }

        if(!$this->orderHub->hub){
            throw new \InvalidArgumentException("Hub not found");
        }

        if(!$this->orderHub->order->status != Order::PACHAGE_PREPARED){
            throw new \InvalidArgumentException("Order must be in Prepared status to process delivery");
        }

    }


}
