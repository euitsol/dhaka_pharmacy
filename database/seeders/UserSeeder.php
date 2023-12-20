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
            'email' => 'user1@euitsols.com',
            'password' => Hash::make('user1@euitsols.com'),
        ]);
       User::create([
            'name' => 'User2',
            'email' => 'user2@euitsols.com',
            'password' => Hash::make('user2@euitsols.com'),
        ]);
       User::create([
            'name' => 'User3',
            'email' => 'user3@euitsols.com',
            'password' => Hash::make('user3@euitsols.com'),
        ]);

    }
}
