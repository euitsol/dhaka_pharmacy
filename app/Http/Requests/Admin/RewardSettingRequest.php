<?php

namespace App\Http\Requests\Admin;

use App\Models\RewardSetting;
use App\Rules\ValidRewardType;
use Illuminate\Foundation\Http\FormRequest;

class RewardSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'rewards' => 'required|array',

            'rewards.*.reward' => 'required|numeric|min:0',

            'rewards.*.reward_type' => [
                'required',
                'integer',
                'in:' . implode(',', [
                    RewardSetting::REWARD_TYPE_AMOUNT,
                    RewardSetting::REWARD_TYPE_PERCENTAGE,
                ]),
                new ValidRewardType() // Custom validation rule
            ],

            'rewards.*.status' => 'required|integer|in:' . implode(',', [
                RewardSetting::STATUS_ACTIVE,
                RewardSetting::STATUS_DEACTIVE,
            ]),
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'rewards.*.reward.required' => 'The reward amount is required.',
            'rewards.*.reward.numeric' => 'The reward must be a numeric value.',
            'rewards.*.reward.min' => 'The reward must be at least 0.',

            'rewards.*.reward_type.required' => 'The reward type is required.',
            'rewards.*.reward_type.integer' => 'The reward type must be a valid integer.',
            'rewards.*.reward_type.in' => 'The reward type must be either Amount or Percentage.',

            'rewards.*.status.required' => 'The status field is required.',
            'rewards.*.status.integer' => 'The status must be a valid integer.',
            'rewards.*.status.in' => 'The status must be either Active or Deactive.',
        ];
    }
}
