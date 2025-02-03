<?php

namespace App\Observers;

use App\Models\Address;
use App\Models\DeliveryZone;
use App\Models\DeliveryZoneCity;
use App\Services\AddressService;

class AddressObserver
{
    private $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function saving(Address $address): void
    {
        if ($address->isDirty('city')) {
            $this->addressService->updateZoneAndExpress($address);
        }
    }

    public function updating(Address $address): void
    {
        if ($address->isDirty('city')) {
            $this->addressService->updateZoneAndExpress($address);
        }
    }
    public function created(Address $address): void {}
    public function updated(Address $address): void {}
    public function deleted(Address $address): void {}
    public function restored(Address $address): void {}
    public function forceDeleted(Address $address): void {}
}
