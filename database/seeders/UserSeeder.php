<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        // Create Users
        User::create([
            'name' => 'User1',
            'phone' => '01711122231',
            'is_verify' => 1,
            'password' => Hash::make('01711122231'),
        ]);
        User::create([
            'name' => 'User2',
            'phone' => '01711122232',
            'is_verify' => 1,
            'password' => Hash::make('01711122232'),
        ]);
        User::create([
            'name' => 'User3',
            'phone' => '01711122233',
            'is_verify' => 1,
            'password' => Hash::make('01711122233'),
        ]);
    }
}