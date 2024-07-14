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
            'key' => 'mapbox_access_token',
            'value' => '',
            'env_key' => 'MAPBOX_ACCESS_TOKEN'
        ]);
        MapboxSetting::create([
            'key' => 'mapbox_style_id',
            'value' => '',
            'env_key' => 'MAPBOX_STYLE_ID',
        ]);
        MapboxSetting::create([
            'key' => 'per_km_delivery_charge',
            'value' => '',
            'env_key' => '',
        ]);
        MapboxSetting::create([
            'key' => 'min_delivery_charge',
            'value' => '',
            'env_key' => 60,
        ]);
        MapboxSetting::create([
            'key' => 'miscellaneous_charge',
            'value' => '',
            'env_key' => '',
        ]);
        MapboxSetting::create([
            'key' => 'warehouse_lat',
            'value' => '',
            'env_key' => 'WAREHOUSE_LAT',
        ]);
        MapboxSetting::create([
            'key' => 'warehouse_long',
            'value' => '',
            'env_key' => 'WAREHOUSE_LONG',
        ]);
    }
}
