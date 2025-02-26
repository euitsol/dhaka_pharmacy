<?php

namespace App\Services;

use App\Models\{Address, DeliveryZone, User, DeliveryZoneCity};
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{DB, Log};
use Illuminate\Support\Str;


class AddressService
{
    protected User|Authenticatable $user;
    protected Address $address;

    public function setUser(User|Authenticatable $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function setAddress(int|null $addressId): self
    {
        $address = Address::find($addressId);
        if (!$address) {
            throw new ModelNotFoundException('Address not found.');
        }
        $this->address = $address;
        return $this;
    }

    public function delete(int $addressId): void
    {
        $address = Address::find($addressId);
        if (!$address) {
            throw new ModelNotFoundException('Address not found.');
        }
        $address->delete();
    }
    public function create(array $data): Address
    {
        return DB::transaction(function () use ($data) {
            $address =Address::create($data);
            $address->creater()->associate($this->user);
            $address->save();

            if (isset($data['is_default']) && $data['is_default'] == true) {
                $this->updateDefaultStatus($address, false);
            }else{
                $this->ensureDefaultAddress($address);
            }
            return $address;
        });
    }

    public function update(int $id, array $data): Address
    {
        return DB::transaction(function () use ($id, $data) {
            $address = Address::findOrFail($id);
            $address->fill($data);
            $address->updater()->associate($this->user);
            $address->save();

            $this->updateDefaultStatus($address, $data['is_default'] ?? false);
            $this->ensureDefaultAddress($address);

            return $address;
        });
    }

    public function list(bool $isDelivery = false, int|null $addressId = null, string|null $search=null): Collection|Address|ModelNotFoundException|array
    {
        $query = Address::select('id', 'zone_id', 'latitude', 'longitude', 'address', 'city', 'street_address', 'apartment', 'floor', 'delivery_instruction', 'is_default')
            ->where('creater_id', $this->user->id)
            ->where('creater_type', get_class($this->user))
            ->with('zone:id,name,charge,allows_express,express_charge,delivery_time_hours,express_delivery_time_hours,status')
            ->orderBy('is_default', 'desc')
            ->when($addressId, fn($q) => $q->where('id', $addressId))
            ->when($search, fn($q) => $q->where('address', 'like', "%$search%"));

        $addresses = $query->get();

        if ($addressId && !$addresses->contains('id', $addressId)) {
            throw new ModelNotFoundException('Address not found.');
        }

        if($isDelivery){
            $addresses = $addresses->map(function ($address) use ($isDelivery) {
                return $this->appendDeliveryDetails($address, $isDelivery);
            });
        }

        return $addressId ? $addresses->first() : $addresses;
    }

    public function getCities(?string $query = null): Collection
    {
        $cities = DeliveryZoneCity::query();
        if ($query) {
            $cities->where('city_name', 'like', "%{$query}%");
        }
        return $cities->orderBy('city_name', 'asc')
                      ->select('id','city_name')
                      ->get();
    }

    protected function updateDefaultStatus(Address $address, bool $isDefault): void
    {
        Address::where('creater_id', $this->user->id)
                ->where('creater_type', get_class($this->user))
                ->update(['is_default' => false]);

        $address->update(['is_default' => true]);

    }

    protected function ensureDefaultAddress(Address $address): void
    {
        $hasDefault = Address::where('creater_id', $this->user->id)
            ->where('creater_type', get_class($this->user))
            ->where('is_default', true)
            ->exists();

        if (!$hasDefault) {
            $address->update(['is_default' => true]);
        }
    }

    //For Address Observer
    public function updateZoneAndExpress(Address $address): void
    {
        $zoneCity = DeliveryZoneCity::where('city_name', $address->city)->first();

        if ($zoneCity) {
            $address->zone_id = $zoneCity->delivery_zone_id;
            $address->load('zone');
            $this->handleExpressEligibility($address, $zoneCity->deliveryZone);
        } else {
            $this->setOutsideDhaka($address);
        }
    }

    protected function handleExpressEligibility(Address $address, DeliveryZone $zone): void
    {
        if ($zone->allows_express) {
            $address->is_express = true;
        }else{
            $address->is_express = false;
        }
    }

    protected function setOutsideDhaka(Address $address): void
    {
        $address->zone_id = DeliveryZone::OUTSIDE_DHAKA_ID;
        $address->is_express = false;
    }
    private function appendDeliveryDetails(Address $address, bool $isDelivery = false): array
    {
        $details = [];
        $details['delivery_options'] = null;


        if ($isDelivery && $address->zone && $address->zone->status == 1) {
            $details['delivery_options'][] = $this->createDeliveryOption(
                type: 'standard',
                charge: $address->zone->charge,
                hours: $address->zone->delivery_time_hours
            );

            if ($address->zone->allows_express) {
                $details['delivery_options'][] = $this->createDeliveryOption(
                    type: 'express',
                    charge: $address->zone->express_charge,
                    hours: $address->zone->express_delivery_time_hours
                );
            }
        }

        return array_merge($address->toArray(), $details);
    }

    private function createDeliveryOption(string $type, float $charge, int $hours): array
    {
        $deliveryDate = $this->calculateDeliveryDate($hours);

        return [
            'name' => Str::title($type),
            'type' => $type,
            'charge' => $charge,
            'delivery_time_hours' => $hours,
            'expected_delivery_date' => $deliveryDate->format('d, M j g:i A'),
        ];
    }

    private function calculateDeliveryDate(int $hours): \DateTime
    {
        $now = now();
        if ($now->hour >= 16) {
            $deliveryDate = $now->addDay()->setTime(14, 0);
        } else {
            $deliveryDate = $now->addHours($hours);
        }

        return $deliveryDate;
    }

    public function getDeliveryCharge(string $deliveryType='standard'): array
    {
        if($this->address->zone->allows_express && $deliveryType == 'express'){
            return [
                'charge' => $this->address->zone->express_charge,
                'delivery_type' => 'express'
            ];
        }
        return [
            'charge' => $this->address->zone->charge,
            'delivery_type' => 'standard'
        ];
    }

    public function defaultAddress(): ?Address
    {
        return Address::where('creater_id', $this->user->id)
            ->where('creater_type', get_class($this->user))
            ->where('is_default', 1)
            ->first();
    }

}
