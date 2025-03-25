<?php

namespace App\Services;

use App\Models\{
    DistrictManager,
    Order,
    RewardSetting,
    Earning,
    LocalAreaManager,
    PointHistory
};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RewardService
{
    protected $rewards;
    protected Order $order;

    public function setOrder(Order $order): self
    {
        $this->order = $order->load(['customer.creater']);
        Log::info('Set Reward Order', ['order' => $this->order]);
        return $this;
    }

    public function checkRewardAbility(): bool
    {
        $createrType = $this->order->customer->creater_type;
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
        $orderAmount = $this->order->total_amount;
        return $reward->reward_type == RewardSetting::REWARD_TYPE_PERCENTAGE
            ? ($orderAmount * $reward->reward / 100)
            : $reward->reward;
    }

    protected function createEarning($receiver, RewardSetting $reward, PointHistory $ph, string $type): void
    {
        $rewardAmount = $this->getRewardAmount($reward);
        $earning = new Earning([
            'point' => $rewardAmount / $ph->eq_amount,
            'eq_amount' => $rewardAmount,
            'activity' => 0,
            'order_id' => $this->order->id,
            'ph_id' => $ph->id,
            'description' => $type == RewardSetting::TYPE_ORDER
                ? 'Order reward bonus income is pending clearance'
                : 'Login reward bonus income is pending clearance'
        ]);
        $earning->receiver()->associate($receiver);
        $earning->source()->associate($reward);
        $earning->save();
        Log::info('Earning Created', ['earning' => $earning]);
    }

    public function addRewardEarning(string $type): void
    {
        DB::transaction(function () use ($type) {
            $receiver = $this->order->customer->creater;
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

    public function completeRewardEarning(): void
    {
        DB::transaction(function () {
            $this->order->earnings()
                ->whereIn('receiver_type', [DistrictManager::class, LocalAreaManager::class])
                ->where('activity', 0)
                ->update(['activity' => 1, 'description' => 'Reward bonus income has been successfully cleared.']);
        });
    }
}
