<?php

namespace App\Http\Traits;

use App\Models\MapboxSetting;
use App\Models\User;

trait DeliveryTrait
{


    /**
     * Calculate the distance between two points on earth in kilometers.
     *
     * @param float $user_lat The latitude of the user's location
     * @param float $user_lng The longitude of the user's location
     * @return float The distance between the user and the default location in km
     */
    function calculateDistance($user_lat, $user_lng)
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


    /**
     * Calculate the delivery charge given the user's location.
     *
     * The delivery charge is calculated as follows:
     * 1. Get the distance between the user's location and the default location
     * 2. Calculate the delivery charge by multiplying the distance by the per km delivery charge
     * 3. Add the miscellaneous charge to the delivery charge
     * 4. If the delivery charge is less than the minimum delivery charge, set it to the minimum delivery charge
     * 5. Return the delivery charge
     *
     * @param float $user_lat The latitude of the user's location
     * @param float $user_lng The longitude of the user's location
     * @return float The delivery charge
     */
    function getDeliveryCharge($user_lat, $user_lng)
    {
        $charges = MapboxSetting::whereIn('key', ['per_km_delivery_charge', 'min_delivery_charge', 'miscellaneous_charge'])->get();
        $per_km_charge = $charges->where('key', 'per_km_delivery_charge')->first();
        $min_charge = $charges->where('key', 'min_delivery_charge')->first();
        $miscellaneous_charge = $charges->where('key', 'miscellaneous_charge')->first();

        $distance = $this->calculateDistance($user_lat, $user_lng);
        $distance = ceil($distance);

        $delivery_charge = $distance * $per_km_charge->value;
        $delivery_charge += $miscellaneous_charge->value;
        if ($delivery_charge < $min_charge->value) {
            $delivery_charge = $min_charge->value;
        }
        return ceil($delivery_charge);
    }
}