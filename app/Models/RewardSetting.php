<?php

namespace App\Models;

use COM;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RewardSetting extends BaseModel
{
    use HasFactory, SoftDeletes;

    public const COMMISSION_TYPE_AMOUNT = 1;
    public const COMMISSION_TYPE_PERCENTAGE = 2;

    public const STATUS_ACTIVE = 0;
    public const STATUS_DEACTIVE = 1;

    public const REWARD_TYPE_LOGIN = 1;
    public const REWARD_TYPE_ORDER = 2;

    public const RECEIVER_TYPE_LAM = 1;
    public const RECEIVER_TYPE_DM = 2;
}
