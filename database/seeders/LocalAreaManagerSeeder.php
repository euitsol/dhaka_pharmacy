<?php

namespace Database\Seeders;

use App\Models\LocalAreaManager;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LocalAreaManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LocalAreaManager::create([
            'dm_id' => 1,
            'name' => 'Test LAM-1',
            'phone' => '01711122231',
            'password' => Hash::make('01711122231'),
            ]);
        LocalAreaManager::create([
                'dm_id' => 2,
                'name' => 'Test LAM-2',
                'phone' => '01711122232',
                'password' => Hash::make('01711122232'),
            ]);
        LocalAreaManager::create([
                'dm_id' => 3,
                'name' => 'Test LAM-3',
                'phone' => '01711122233',
                'password' => Hash::make('01711122233'),
            ]);
    }
}
