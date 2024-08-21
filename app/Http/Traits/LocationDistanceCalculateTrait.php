<?php

namespace App\Http\Traits;

use App\Models\MapboxSetting;
use App\Models\User;

trait LocationDistanceCalculateTrait
{


    function getDistance($user_lat, $user_lng)
    {
        $default_lat = config('mapbox.center_location_lat');
        $default_lng = config('mapbox.center_location_lng');
        // convert from degrees to radians
        $earthRadius = 6371000;
        $latFrom = deg2rad($default_lat);
        $lonFrom = deg2rad($default_lng);
        $latTo = deg2rad($user_lat);
        $lonTo = deg2rad($user_lng);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return ($angle * $earthRadius) / 1000;
    }

    function updateUserDeliveryFee()
    {
        $charges = MapboxSetting::whereIn('key', ['per_km_delivery_charge', 'min_delivery_charge', 'miscellaneous_charge'])->get();
        $per_km_charge = $charges->where('key', 'per_km_delivery_charge')->first();
        $min_charge = $charges->where('key', 'min_delivery_charge')->first();
        $miscellaneous_charge = $charges->where('key', 'miscellaneous_charge')->first();
        // $distances = [];
        $user = User::with('address')->findOrFail(user()->id);
        foreach ($user->address  as $address) {
            $user_lat = $address->latitude;
            $user_lng = $address->longitude;

            $distance = $this->getDistance($user_lat, $user_lng);
            $distance = ceil($distance);
            // array_push($distances, ceil($distance));

            $delivery = $distance * $per_km_charge->value;
            $delivery += $miscellaneous_charge->value;
            if ($delivery < $min_charge->value) {
                $delivery = $min_charge->value;
            }
            $address->delivery_charge = $delivery;
            $address->save();
        }
        // dd($distances);
    }
}