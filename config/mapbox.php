<?php
return [
    'mapbox_token' => (env('MAPBOX_TOKEN', 'pk.eyJ1IjoicXdhc3p4MzQyNDMyIiwiYSI6ImNsd2t4ZnU2ZTA3emYyam54aXdqdTFocWYifQ.tXzncKk2GtbOXVtZvqZOIA')),
    'mapbox_style_id'=>(env('MAPBOX_STYLE_ID', 'mapbox://styles/mapbox/streets-v9')),
    'center_location_lng' => (env('MAP_CENTER_LNG','90.36861120637')),
    'center_location_lat' => (env('MAP_CENTER_LAT','23.80709010170405')),
    'pharmacy_radious' => (env('MAP_PHARMACY_RADIOUS', 10)),
];