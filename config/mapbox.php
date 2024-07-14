<?php
return [
    'mapbox_token' => (env('MAPBOX_TOKEN', null)),
    'center_location_lng' => (env('MAP_CENTER_LNG')),
    'center_location_lat' => (env('MAP_CENTER_LAT')),
    'pharmacy_radious' => (env('MAP_PHARMACY_RADIOUS', 10)),
];