<?php

namespace App\Services;
use App\Models\OrderHub;
use SteadFast\SteadFastCourierLaravelPackage\SteadfastCourier;

class SteadFastService
{
    public function createShipment(OrderHub $orderHub)
    {

    }

    protected function prepareSteadFastOrder(OrderHub $orderHub)
    {
        return [
            'invoice' => $orderHub->order->order_number,
        ];
    }
}
