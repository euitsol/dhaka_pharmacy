<?php

namespace App\Services;

use App\Models\Order;
use App\Services\SteadFastService;
use App\Models\OrderHub;

class OrderDeliveryService
{
    protected SteadFastService $steadFastService;
    protected OrderHub $orderHub;
    protected String $type;

    public function __construct(SteadFastService $steadFastService)
    {
        $this->steadFastService = $steadFastService;
    }

    public function setOrderHub(OrderHub $orderHub):self
    {
        $this->orderHub = $orderHub;
        return $this;
    }

    public function setType(String $type):self
    {
        $this->type = $type;
        return $this;
    }

    public function processDelivery(string $type)
    {
        $this->validateDelivery();
        if($this->type === 'steadfast'){
            $this->steadFastService->createShipment($this->orderHub);
        }
    }

    public function createDelivery(OrderHub $orderHub)
    {

    }

    public function validateDelivery()
    {
        if(!$this->orderHub){
            throw new \InvalidArgumentException("Order hub not found");
        }

        if(!$this->type || $this->type !== 'steadfast'){
            throw new \InvalidArgumentException("Type not found");
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
