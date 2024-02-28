<?php

namespace Database\Seeders;

use App\Models\DistrictManager;
use App\Models\OperationArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DistrictManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OperationArea::create([
            'name' => 'Mirpur-10',
            'slug' => 'mirpur-10',
        ]);
        DistrictManager::create([
            'name' => 'Test DM-1',
            'phone' => '01711122231',
            'password' => Hash::make('01711122231'),
            'oa_id'=>1,
        ]);
        DistrictManager::create([
            'name' => 'Test DM-2',
            'phone' => '01711122232',
            'password' => Hash::make('01711122232'),
            'oa_id'=>1,
        ]);
        DistrictManager::create([
            'name' => 'Test DM-3',
            'phone' => '01711122233',
            'password' => Hash::make('01711122233'),
            'oa_id'=>1,
        ]);

        
    }
}
