<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryZone extends BaseModel
{
    use HasFactory, SoftDeletes;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;
    public const INSIDE_DHAKA_ID = 1;
    public const INSIDE_DHAKA_SUBURB_ID = 2;
    public const OUTSIDE_DHAKA_ID = 3;


    protected $fillable = ['id', 'name', 'charge', 'delivery_time_hours', 'allows_express', 'express_charge', 'express_delivery_time_hours', 'status'];
    protected $appends = ['status_string'];

    public function cities(): HasMany
    {
        return $this->hasMany(DeliveryZoneCity::class);
    }

    public function getStatusStringAttribute(): string
    {
        return match($this->status) {
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            default => 'Unknown Status',
        };
    }
}
