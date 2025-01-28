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

        // Check if this is the first address and set it as default if necessary
        $isFirstAddress = !Address::where('creater_id', $user->id)
            ->where('creater_type', get_class($user))
            ->where('is_default', 1)
            ->exists();
        $save->is_default = $isFirstAddress;
        $save->save();

        return sendResponse(true, 'New address added successfully.');
    }
    public function update(AddressRequest $request): JsonResponse
    {
        $user = $request->user();
        $address_id = $request->address_id;

        $query = Address::where('creater_id', $user->id)->where('creater_type', get_class($user));
        $save = $query->where('id', $address_id)->get()->first();
        $save->latitude = $request->latitude;
        $save->longitude = $request->longitude;
        $save->address = $request->address;
        $save->city = $request->city;
        $save->street_address = $request->street_address;
        $save->apartment = $request->apartment;
        $save->floor = $request->floor;
        $save->is_default = $request->is_default ?? false;
        $save->delivery_instruction = $request->delivery_instruction;
        $save->note = $request->note;
        $save->updater()->associate($user);
        $save->update();

        return sendResponse(true, 'Address updated successfully.');
    }

    public function list(Request $request)
    {
        $user = $request->user();
        $address_list = Address::select('id','latitude','longitude','address','city','street_address','apartment','floor','delivery_instruction','is_default')->where('creater_id', $user->id)->where('creater_type', get_class($user))->orderBy('is_default', 'desc')->get();
        if ($request->delivery) {
            $address_list->each(function (&$address) {
                $address->delivery_charge = $this->getDeliveryCharge($address->latitude, $address->longitude);
            });
        }
        return sendResponse(true, 'Address list retrived successfully', $address_list);
    }
}
