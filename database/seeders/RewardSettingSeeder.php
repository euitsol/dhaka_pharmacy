<?php

namespace Database\Seeders;

use App\Models\RewardSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RewardSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RewardSetting::truncate();
        $rewardSettings = [
            [
                'type' => RewardSetting::TYPE_LOGIN,
                'receiver_type' => RewardSetting::RECEIVER_TYPE_LAM,
            ],
            [
                'type' => RewardSetting::TYPE_LOGIN,
                'receiver_type' => RewardSetting::RECEIVER_TYPE_DM,
            ],
            [
                'type' => RewardSetting::TYPE_ORDER,
                'receiver_type' => RewardSetting::RECEIVER_TYPE_LAM,
            ],
            [
                'type' => RewardSetting::TYPE_ORDER,
                'receiver_type' => RewardSetting::RECEIVER_TYPE_DM,
            ],
        ];

        foreach ($rewardSettings as $rewardSetting) {
            RewardSetting::create($rewardSetting);
        }
    }
}
