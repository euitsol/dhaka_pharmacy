<?php

namespace App\Rules;

use App\Models\RewardSetting;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidRewardType implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Extract the reward ID from the attribute name
        preg_match('/rewards\.(\d+)\.reward_type/', $attribute, $matches);
        $rewardId = $matches[1] ?? null;

        if ($rewardId) {
            // Retrieve the reward from the database
            $reward = RewardSetting::whereId($rewardId)->first();

            if ($reward && $reward->type == RewardSetting::TYPE_LOGIN && $value == RewardSetting::REWARD_TYPE_PERCENTAGE) {
                $fail('For Login type rewards, only Amount-based rewards are allowed.');
            }
        }
    }
}