<?php

namespace App\Observers;

use App\Models\RewardSetting;
use App\Models\User;
use App\Services\RewardService;

class UserObserver
{
    private RewardService $rewardService;

    public function __construct(RewardService $rewardService)
    {
        $this->rewardService = $rewardService;
    }
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $this->rewardService->setUser($user);
        if ($this->rewardService->checkRewardAbility()) {
            $this->rewardService->addRewardEarning(RewardSetting::TYPE_LOGIN);
        };
    }



    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if ($user->wasChanged('is_verify') && $user->is_verify == 1) {
            $user->load('earnings.reward');
            if ($user->earnings->count() > 0) {
                $this->rewardService->completeRewardEarning($user->earnings());
            }
        }
    }
}
