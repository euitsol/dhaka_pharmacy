<?php

namespace Database\Seeders;

use App\Models\Pharmacy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PharmacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Pharmacy
        Pharmacy::create([
            'name' => 'Pharmacy1',
            'email' => 'pharmacy1@euitsols.com',
            'password' => Hash::make('pharmacy1@euitsols.com'),
        ]);
        Pharmacy::create([
            'name' => 'Pharmacy2',
            'email' => 'pharmacy2@euitsols.com',
            'password' => Hash::make('pharmacy2@euitsols.com'),
        ]);
        Pharmacy::create([
            'name' => 'Pharmacy3',
            'email' => 'pharmacy3@euitsols.com',
            'password' => Hash::make('pharmacy3@euitsols.com'),
        ]);
    }
}