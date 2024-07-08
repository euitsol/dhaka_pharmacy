<?php

namespace Database\Seeders;

use App\Models\PointSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PointSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PointSetting::create([
            'key' => 'point_name',
            'value' => 'DP',
        ]);
    }
}