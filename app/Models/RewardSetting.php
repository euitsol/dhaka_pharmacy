<?php

namespace App\Models;

use COM;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RewardSetting extends BaseModel
{
    use HasFactory, SoftDeletes;

    public const REWARD_TYPE_AMOUNT = 1;
    public const REWARD_TYPE_PERCENTAGE = 2;

    public const STATUS_ACTIVE = 0;
    public const STATUS_DEACTIVE = 1;

    public const TYPE_LOGIN = 1;
    public const TYPE_ORDER = 2;

    public const RECEIVER_TYPE_LAM = 1;
    public const RECEIVER_TYPE_DM = 2;

    protected $fillable = [
        'type',
        'receiver_type',
        'reward',
        'reward_type',
        'status',
    ];

    protected $appends = [
        'status_string',
        'status_strings',
        'status_badge_color',
        'type_string',
        'type_strings',
        'type_badge_color',
        'receiver_type_string',
        'receiver_type_badge_color',
        'reward_type_string',
        'reward_type_strings',
        'reward_type_badge_color',
    ];

    public static function getStatusStrings(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DEACTIVE => 'Deactive',
        ];
    }
    public function getStatusStringAttribute()
    {
        return match ($this->status) {
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DEACTIVE => 'Deactive',
            default => 'Unknown Status',
        };
    }

    public function getStatusStringsAttribute()
    {
        return $this->getStatusStrings();
    }

    public function getStatusBadgeColorAttribute()
    {
        return match ($this->status) {
            self::STATUS_ACTIVE => 'bg-success',
            self::STATUS_DEACTIVE => 'bg-danger',
            default => 'bg-secondary',
        };
    }
    public static function getTypes(): array
    {
        return [
            self::TYPE_LOGIN => 'Login',
            self::TYPE_ORDER => 'Order',
        ];
    }
    public function getTypeStringAttribute()
    {
        return match ($this->type) {
            self::TYPE_LOGIN => 'Login',
            self::TYPE_ORDER => 'Order',
            default => 'Unknown Type',
        };
    }
    public function getTypeStringsAttribute()
    {
        return $this->getTypes();
    }


    public function getTypeBadgeColorAttribute()
    {
        return match ($this->type) {
            self::TYPE_LOGIN => 'bg-primary',
            self::TYPE_ORDER => 'bg-info',
            default => 'bg-secondary',
        };
    }

    public static function getReceiverTypes(): array
    {
        return [
            self::RECEIVER_TYPE_LAM => 'Local Area Manager',
            self::RECEIVER_TYPE_DM => 'District Manager',
        ];
    }
    public function getReceiverTypeStringAttribute()
    {
        return match ($this->receiver_type) {
            self::RECEIVER_TYPE_LAM => 'Local Area Manager',
            self::RECEIVER_TYPE_DM => 'District Manager',
            default => 'Unknown Receiver Type',
        };
    }
    public function getReceiverTypeStringsAttribute()
    {
        return $this->getReceiverTypes();
    }
    public function getReceiverTypeBadgeColorAttribute()
    {
        return match ($this->receiver_type) {
            self::RECEIVER_TYPE_LAM => 'bg-primary',
            self::RECEIVER_TYPE_DM => 'bg-info',
            default => 'bg-secondary',
        };
    }
    public static function getRewardTypes(): array
    {
        return [
            self::REWARD_TYPE_AMOUNT => 'Flat Amount',
            self::REWARD_TYPE_PERCENTAGE => 'Percent Amount',
        ];
    }
    public function getRewardTypeStringAttribute()
    {
        return match ($this->reward_type) {
            self::REWARD_TYPE_AMOUNT => 'Flat Amount',
            self::REWARD_TYPE_PERCENTAGE => 'Percent Amount',
            default => 'Unknown Reward Type',
        };
    }
    public function getRewardTypeStringsAttribute()
    {
        return $this->getRewardTypes();
    }
    public function getRewardTypeBadgeColorAttribute()
    {
        return match ($this->reward_type) {
            self::REWARD_TYPE_AMOUNT => 'bg-primary',
            self::REWARD_TYPE_PERCENTAGE => 'bg-info',
            default => 'bg-secondary',
        };
    }

    public function scopeActive()
    {
        return $this->where('status', self::STATUS_ACTIVE);
    }

    public function scopeType($type)
    {
        return $this->where('type', $type);
    }
}
