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
            'user_id' => 1,
            'name' => 'Md Shariful Islam',
            'phone' => '01792980503',
            'city' => 'Lalmonirhat',
            'street_address' => 'Baninagar, Kakina, Kaliganj, Lalmonirhat, Rangpur.',
            'latitude' => '25.952858464386182',
            'longitude' => '89.24699435090237',
            'apartment' => 'N/A',
            'floor' => 'N/A',
            'apartment_type' => 'home',
            'delivery_instruction' => 'Please give me a call before delivering my product.',
        ]);
        











    }
}
