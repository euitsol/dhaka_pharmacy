<?php

namespace App\Services;

use App\Models\{
    DistrictManager,
    Order,
    RewardSetting,
    Earning,
    LocalAreaManager,
    PointHistory,
    User
};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RewardService
{
    protected $rewards;
    protected Order $order;
    protected User $user;

    public function setOrder(Order $order): self
    {
        $this->order = $order->load(['customer.creater']);
        $this->setUser($this->order->customer);
        Log::info('Set Reward Order', ['order' => $this->order]);
        return $this;
    }

    public function setUser(User $user): self
    {
        $this->user = $user->load(['creater']);
        Log::info('User Set ', ['user' => $this->user]);
        return $this;
    }

    public function checkRewardAbility(): bool
    {
        $createrType = $this->user->creater_type;
        $isEligible = in_array($createrType, [LocalAreaManager::class, DistrictManager::class]);
        Log::info('Reward Ability', ['eligible' => $isEligible]);
        return $isEligible;
    }

    public function setRewards(string $type): void
    {
        $this->rewards = RewardSetting::active()->where('type', $type)->latest()->get();
        Log::info('Set Rewards', ['type' => $type, 'rewards' => $this->rewards]);
    }

    protected function getRewardAmount(RewardSetting $reward): float
    {
        if (isset($this->order)) {
            return $reward->reward_type == RewardSetting::REWARD_TYPE_PERCENTAGE
                ? ($this->order->total_amount * $reward->reward / 100)
                : $reward->reward;
        }
        if ($reward->type == RewardSetting::TYPE_LOGIN && $reward->reward_type == RewardSetting::REWARD_TYPE_AMOUNT) {
            return $reward->reward;
        }
        return 0;
    }

    protected function createEarning($receiver, RewardSetting $reward, PointHistory $ph, string $type): void
    {
        $rewardAmount = $this->getRewardAmount($reward);
        $earning = new Earning([
            'point' => $rewardAmount / $ph->eq_amount,
            'eq_amount' => $rewardAmount,
            'activity' => -1,
            'ph_id' => $ph->id,
            'reward_id' => $reward->id ?? null,
            'description' => $type == RewardSetting::TYPE_ORDER
                ? 'The order reward bonus income has been initiated.'
                : 'The login reward bonus income has been initiated'
        ]);
        $earning->receiver()->associate($receiver);
        $earning->source()->associate(isset($this->order) ? $this->order : $this->user);
        $earning->save();
        Log::info('Earning Created', ['earning' => $earning]);
    }

    public function addRewardEarning(string $type): void
    {
        DB::transaction(function () use ($type) {
            $this->setRewards($type);
            $receiver = $this->user->creater;
            $ph = PointHistory::activated()->first();
            if (!$receiver || !$ph) {
                Log::warning('Reward Earning Skipped', ['receiver' => $receiver, 'pointHistory' => $ph]);
                return;
            }

            if ($receiver instanceof LocalAreaManager) {
                $lamReward = RewardSetting::active()->where(['type' => $type, 'receiver_type' => RewardSetting::RECEIVER_TYPE_LAM])->first();
                if ($lamReward) {
                    $this->createEarning($receiver, $lamReward, $ph, $type);
                }
                $receiver->load('dm');
                $dmReward = RewardSetting::active()->where(['type' => $type, 'receiver_type' => RewardSetting::RECEIVER_TYPE_DM])->first();
                if ($dmReward && $receiver->dm) {
                    $this->createEarning($receiver->dm, $dmReward, $ph, $type);
                }
            }

            if ($receiver instanceof DistrictManager) {
                $dmReward = $this->rewards->where('receiver_type', RewardSetting::RECEIVER_TYPE_DM)->first();
                if ($dmReward) {
                    $this->createEarning($receiver, $dmReward, $ph, $type);
                }
            }
        });
    }

    public function completeRewardEarning($earnings): void
    {
        DB::transaction(function () use ($earnings) {
            $earnings->where('activity', -1)
                ->update(['activity' => 0, 'description' => 'The income is pending clearance.']);
        });
    }
}
