<?php

namespace Database\Seeders;

use App\Models\DeliveryZone;
use App\Models\DeliveryZoneCity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryZonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // DeliveryZoneCity::truncate();
        // DeliveryZone::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Dhaka City Zone
        $dhakaCity = DeliveryZone::create([
            'id' => DeliveryZone::INSIDE_DHAKA_ID,
            'name' => 'Dhaka City',
            'charge' => 60,
            'delivery_time_hours' => 24,
            'allows_express' => true,
            'express_charge' => 100,
            'express_delivery_time_hours' => 6,
            'status' => DeliveryZone::STATUS_ACTIVE
        ]);
        $dhakaCities = ['Dhaka City'];
        $dhakaCity->cities()->createMany(
            array_map(fn($city) => ['city_name' => $city], $dhakaCities)
        );

        // Dhaka Sub-Urban Zone
        $dhakaSuburb = DeliveryZone::create([
            'id' => DeliveryZone::INSIDE_DHAKA_SUBURB_ID,
            'name' => 'Dhaka Sub-Urban',
            'charge' => 80,
            'delivery_time_hours' => 24,
            'allows_express' => false,
            'status' => DeliveryZone::STATUS_ACTIVE
        ]);
        $dhakaSuburbCities = [
            'Dhaka Sub-Urban', 'Keraniganj', 'Ashulia', 'Dhamrai', 'Hemayetpur','Narayanganj','Savar','Dohar','Gazipur','Tongi'];
        $dhakaSuburb->cities()->createMany(
            array_map(fn($city) => ['city_name' => $city], $dhakaSuburbCities)
        );

        // Outside Dhaka Zone
        $outsideDhaka = DeliveryZone::create([
            'id' => DeliveryZone::OUTSIDE_DHAKA_ID,
            'name' => 'Outside Dhaka',
            'charge' => 100,
            'delivery_time_hours' => 72,
            'allows_express' => false,
            'status' => DeliveryZone::STATUS_ACTIVE
        ]);

        // All other cities
        $outsideCities = [
            'Bagerhat', 'Bandarban', 'Barguna', 'Barishal', 'Bhola',
            'Bogra', 'Brahmanbaria', 'Chandpur', 'Chapainawabganj',
            'Chittagong', 'Chuadanga', "Cox's Bazar", 'Cumilla', 'Dinajpur',
            'Faridpur', 'Feni', 'Gaibandha', 'Gopalganj',
            'Habiganj', 'Jamalpur', 'Jashore', 'Jhalokati', 'Jhenaidah',
            'Joypurhat', 'Khagrachori', 'Khulna', 'Kishoreganj', 'Kurigram',
            'Kustia', 'Lalmonirhat', 'Laxmipur', 'Madaripur', 'Magura',
            'Manikganj', 'Meherpur', 'Moulvibazar', 'Munshiganj', 'Mymenshingh',
            'Naogaon', 'Narail', 'Narshindi', 'Natore',
            'Netrokona', 'Nilphamari', 'Noakhali', 'Pabna', 'Panchgarh',
            'Patuakhali', 'Pirojpur', 'Rajbari', 'Rajshahi', 'Rangamati',
            'Rangpur', 'Shariatpur', 'Shatkhira', 'Sherpur', 'Sirajganj',
            'Sunamganj', 'Sylhet', 'Tangail', 'Thakurgaon'
        ];

        $outsideDhaka->cities()->createMany(
            array_map(fn($city) => ['city_name' => $city], $outsideCities)
        );
    }
}
