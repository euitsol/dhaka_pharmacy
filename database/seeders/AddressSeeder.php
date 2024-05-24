<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Address::create([
            'city' => 'Mirpur - 10',
            'street_address' => '123 Main St',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'apartment' => 'Apt 101',
            'floor' => '2nd',
            'delivery_instruction' => 'Ring the bell twice',
            'created_at' => now(),
            'address' => '123 Main St, Mirpur - 10',
            'note' => 'This is a sample address note',
            'creater_id' => 1,
            'creater_type' => 'App\Models\User'
        ]);
        Address::create([
            'city' => 'Mirpur - 10',
            'street_address' => '123 Main St',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'apartment' => 'Apt 101',
            'floor' => '2nd',
            'delivery_instruction' => 'Ring the bell twice',
            'created_at' => now(),
            'address' => '123 Main St, Mirpur - 10',
            'note' => 'This is a sample address note',
            'creater_id' => 2,
            'creater_type' => 'App\Models\User'
        ]);
        Address::create([
            'city' => 'Mirpur - 10',
            'street_address' => '123 Main St',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'apartment' => 'Apt 101',
            'floor' => '2nd',
            'delivery_instruction' => 'Ring the bell twice',
            'created_at' => now(),
            'address' => '123 Main St, Mirpur - 10',
            'note' => 'This is a sample address note',
            'creater_id' => 3,
            'creater_type' => 'App\Models\User'
        ]);
    }
}
