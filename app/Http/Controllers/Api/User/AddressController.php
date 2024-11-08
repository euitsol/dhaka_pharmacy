<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\API\AddressRequest;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Traits\DeliveryTrait;

class AddressController extends BaseController
{
    use DeliveryTrait;
    public function store(AddressRequest $request): JsonResponse
    {
        $user = $request->user();
        if ($user) {
            $save = new Address();
            $save->latitude = $request->latitude;
            $save->longitude = $request->longitude;
            $save->address = $request->address;
            $save->city = $request->city;
            $save->street_address = $request->street_address;
            $save->apartment = $request->apartment;
            $save->floor = $request->floor;
            $save->delivery_instruction = $request->delivery_instruction;
            $save->note = $request->note;
            $save->creater()->associate($user);
            $save->save();

            //DEFAULT
            $count = Address::where('creater_id', $user->id)->where('creater_type', get_class($user))->where('is_default', 1)->get()->count();
            if ($count == 0) {
                $save->is_default = true;
                $save->save();
            }
            return sendResponse(true, 'New address added successfully.');
        } else {
            return sendResponse(false, 'Invalid User', null);
        }
    }
    public function update(AddressRequest $request): JsonResponse
    {
        $user = $request->user();
        $address_id = $request->address_id;
        if ($user) {
            $query = Address::where('creater_id', $user->id)->where('creater_type', get_class($user));
            if ($request->is_default == 1) {
                $query->update(['is_default' => 0]);
            }
            $save = $query->where('id', $address_id)->get()->first();
            $save->latitude = $request->latitude;
            $save->longitude = $request->longitude;
            $save->address = $request->address;
            $save->city = $request->city;
            $save->street_address = $request->street_address;
            $save->apartment = $request->apartment;
            $save->floor = $request->floor;
            $save->is_default = $request->is_default;
            $save->delivery_instruction = $request->delivery_instruction;
            $save->note = $request->note;
            $save->updater()->associate($user);
            $save->update();
            return sendResponse(true, 'Address updated successfully.');
        } else {
            return sendResponse(false, 'Invalid User', null);
        }
    }

    public function list(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $address_list = Address::where('creater_id', $user->id)->where('creater_type', get_class($user))->orderBy('is_default', 'desc')->get();
            if ($request->delivery) {
                $address_list->each(function (&$address) {
                    $address->delivery_charge = $this->getDeliveryCharge($address->latitude, $address->longitude);
                });
            }
            return sendResponse(true, $user->name . ' address list retrived successfully', $address_list);
        } else {
            return sendResponse(false, 'Invalid User', null);
        }
    }
}