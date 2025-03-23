<?php

namespace App\Services;

use App\Models\{DistrictManager, Order, Payment, RewardSetting, Earning, LocalAreaManager, PointHistory};
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RewardService
{
    protected $rewards;
    protected Order $order;

    public function setOrder(Order $order): self
    {
        $this->order = $order->load(['customer.creater']);
        Log::info('Set Reward Order ' . $this->order);
        return $this;
    }
    public function checkRewardAbility()
    {
        if ($this->order->customer->creater_type = LocalAreaManager::class || $this->order->creater_type = DistrictManager::class) {
            return true;
            Log::info('Reward Ability True');
        }
        return false;
        Log::info('Reward Ability False');
    }

    public function setRewards($type)
    {
        $this->rewards = RewardSetting::active()->where('type', $type)->latest()->get();
        Log::info('Type Rewards ' . $this->rewards->get());
    }

    protected function getRewardAmount($reward)
    {
        $order_amount = $this->order->total_amount;
        return $reward->reward_type == RewardSetting::REWARD_TYPE_PERCENTAGE ? $order_amount / 100 * $reward->reward : $reward->reward;
    }

    public function addRewardEarning($type)
    {
        DB::transaction(function () use ($type) {
            Log::info('Order Customer ' . $this->order->customer);
            $receiver = $this->order->customer->creater;
            Log::info('Reward Receiver ' . $receiver);
            $ph = PointHistory::activated()->first();
            Log::info('Active Point ' . $ph);

            if ($receiver) {
                if (get_class($receiver) == LocalAreaManager::class) {

                    $reward = RewardSetting::active()->where('type', $type)->where('receiver_type', RewardSetting::RECEIVER_TYPE_LAM)->first();
                    Log::info('LAM Reward ' . $reward);

                    $reward_amount = $this->getRewardAmount($reward);
                    Log::info('Reward Amount ' . $reward_amount);

                    // LAM Reward Earning
                    $earning = new Earning();
                    $earning->point =  $reward_amount / $ph->eq_amount;
                    $earning->eq_amount = $reward_amount;
                    $earning->activity = 0;
                    $earning->receiver()->associate($receiver);
                    $earning->source()->associate($reward);
                    $earning->order_id = $this->order->id;
                    $earning->ph_id = $ph->id;
                    $earning->description = 'Order reward bonus';
                    $earning->save();
                    Log::info('LAM Earning ' . $earning);

                    $reward = RewardSetting::active()->where('type', $type)->where('receiver_type', RewardSetting::RECEIVER_TYPE_DM)->first();

                    Log::info('DM Reward ' . $reward);
                    $reward_amount = $this->getRewardAmount($reward);
                    Log::info('Reward Amount ' . $reward_amount);
                    $receiver->load('dm');
                    Log::info('Receiver DM ' . $receiver->dm);

                    // DM Reward Earning for LAM's DM
                    $earning = new Earning();
                    $earning->point =  $reward_amount / $ph->eq_amount;
                    $earning->eq_amount = $reward_amount;
                    $earning->activity = 0;
                    $earning->receiver()->associate($receiver->dm);
                    $earning->source()->associate($reward);
                    $earning->order_id = $this->order->id;
                    $earning->ph_id = $ph->id;
                    $earning->description = 'Order reward bonus';
                    $earning->save();
                    Log::info('DM Earning ' . $earning);
                } else {
                    $reward = $this->rewards->where('receiver_type', RewardSetting::RECEIVER_TYPE_DM)->first();
                    Log::info('DM Reward ' . $reward);
                    $reward_amount = $this->getRewardAmount($reward);
                    Log::info('Reward Amount ' . $reward_amount);

                    // DM Reward Earning
                    $earning = new Earning();
                    $earning->point =  $reward_amount / $ph->eq_amount;
                    $earning->eq_amount = $reward_amount;
                    $earning->activity = 0;
                    $earning->receiver()->associate($receiver);
                    $earning->source()->associate($reward);
                    $earning->order_id = $this->order->id;
                    $earning->ph_id = $ph->id;
                    $earning->description = 'Order reward bonus';
                    $earning->save();
                    Log::info('DM Earning ' . $earning);
                }
            }
        }, 5); // The "5" is the number of times to attempt the transaction in case of deadlock
    }
}