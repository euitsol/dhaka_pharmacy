<?php

namespace Database\Seeders;

use App\Models\MapboxSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MapboxSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MapboxSetting::create([
            'key' => 'mapbox_token',
            'value' => 'pk.eyJ1IjoicXdhc3p4MzQyNDMyIiwiYSI6ImNsd2t4ZnU2ZTA3emYyam54aXdqdTFocWYifQ.tXzncKk2GtbOXVtZvqZOIA',
            'env_key' => 'MAPBOX_TOKEN'
        ]);
        MapboxSetting::create([
            'key' => 'mapbox_style_id',
            'value' => 'mapbox://styles/mapbox/streets-v9',
            'env_key' => 'MAPBOX_STYLE_ID',
        ]);
        MapboxSetting::create([
            'key' => 'per_km_delivery_charge',
            'value' => 30,
            'env_key' => 'PER_KM_DELIVERY_CHARGE',
        ]);
        MapboxSetting::create([
            'key' => 'min_delivery_charge',
            'value' => 60,
            'env_key' => 'MIN_DELIVERY_CHARGE',
        ]);
        MapboxSetting::create([
            'key' => 'miscellaneous_charge',
            'value' => 10,
            'env_key' => 'MISCELLANEOUS_CHARGE',
        ]);
        MapboxSetting::create([
            'key' => 'center_location_lat',
            'value' => '23.80709010170405',
            'env_key' => 'MAP_CENTER_LAT',
        ]);
        MapboxSetting::create([
            'key' => 'center_location_lng',
            'value' => '90.36861120637',
            'env_key' => 'MAP_CENTER_LNG',
        ]);
        MapboxSetting::create([
            'key' => 'pharmacy_radious',
            'value' => '',
            'env_key' => 'MAP_PHARMACY_RADIOUS',
        ]);
    }
}