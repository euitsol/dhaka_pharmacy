<?php

namespace Database\Seeders;

use App\Models\Rider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RiderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rider::create([
            'name' => 'Rider-1',
            'phone' => '01711122231',
            'password' => Hash::make('01711122231'),
            'is_verify' => 1,
            'oa_id' => 1,
            'osa_id' => 1,
        ]);
        Rider::create([
            'name' => 'Rider-2',
            'phone' => '01711122232',
            'password' => Hash::make('01711122232'),
            'is_verify' => 1,
            'oa_id' => 1,
            'osa_id' => 4,
        ]);
        Rider::create([
            'name' => 'Rider-3',
            'phone' => '01711122233',
            'password' => Hash::make('01711122233'),
            'is_verify' => 1,
            'oa_id' => 2,
            'osa_id' => 11,
        ]);
    }
}