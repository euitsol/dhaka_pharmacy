<?php

namespace App\Http\Traits;

trait LocationDistanceCalculateTrait
{

    function getDistance($default_lat, $default_lng, $user_lat, $user_lng, $unit = 'K')
    {

        $theta = $default_lng - $user_lng;
        $dist = sin(deg2rad($default_lat)) * sin(deg2rad($user_lat)) + cos(deg2rad($default_lat)) * cos(deg2rad($user_lat)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}
