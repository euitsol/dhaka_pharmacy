<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Voucher extends BaseModel
{
    use HasFactory, SoftDeletes;

    public const TYPE_PERCENTAGE = 1;
    public const TYPE_FIXED = 2;
    public const TYPE_FREE_SHIPPING = 3;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    protected $fillable = [
        'code', 'type', 'discount_amount',
        'min_order_amount', 'starts_at', 'expires_at',
        'usage_limit', 'user_usage_limit', 'status'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected $appends = [
        'redemptions_count',
        'type_string',
        'type_badge_class',
        'status_string',
        'status_badge_class',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format($this->getDateTimeFormat());
    }

    public function redemptions(): HasMany
    {
        return $this->hasMany(VoucherRedemption::class);
    }

    public function getRedemptionsCountAttribute(): int
    {
        if (!$this->relationLoaded('redemptions')) {
            return $this->redemptions()->count();
        }

        return $this->redemptions->count();
    }

    public function isUsedByUser(int $userId): bool
    {
        return $this->redemptions()
            ->where('user_id', $userId)
            ->exists();
    }

    public function isValid(): bool
    {
        return $this->status === self::STATUS_ACTIVE &&
            $this->isActivePeriod() &&
            !$this->hasReachedUsageLimit();
    }

    public function isActivePeriod(): bool
    {
        Log::info("Starts At: {$this->starts_at}");
        Log::info("Expires At: {$this->expires_at}");
        Log::info("Now: " . now());
        return now()->between($this->starts_at, $this->expires_at);
    }

    public function hasReachedUsageLimit(): bool
    {
        return $this->redemptions_count >= $this->usage_limit;
    }

    public function hasUserReachedLimit(int $userId): bool
    {
        return $this->redemptions()
            ->where('user_id', $userId)
            ->count() >= $this->user_usage_limit;
    }

    public function scopeValid(Builder $query): Builder
    {
        return $query->activated()
            ->where('starts_at', '<=', now())
            ->where('expires_at', '>=', now());
    }

    public function calculateDiscount(float $subTotal): float
    {
        return match($this->type) {
            self::TYPE_PERCENTAGE => round($subTotal * ($this->discount_amount / 100), 2),
            self::TYPE_FIXED => min($this->discount_amount, $subTotal),
            self::TYPE_FREE_SHIPPING => 0,
            default => 0,
        };
    }

    public function getTypeStringAttribute(): string
    {
        return match($this->type) {
            self::TYPE_PERCENTAGE => 'Percentage',
            self::TYPE_FIXED => 'Fixed Amount',
            self::TYPE_FREE_SHIPPING => 'Free Shipping',
            default => 'Unknown Type',
        };
    }

    public function getTypeBadgeClassAttribute(): string
    {
        return match($this->type) {
            self::TYPE_PERCENTAGE => 'badge-info',
            self::TYPE_FIXED => 'badge-primary',
            self::TYPE_FREE_SHIPPING => 'badge-success',
            default => 'badge-secondary',
        };
    }

    public function getStatusStringAttribute(): string
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return $this->status ? 'badge-success' : 'badge-danger';
    }

    public function isMinOrderAmountReached(Order $order): bool
    {
       if ($this->min_order_amount > 0) {
            return $order->total_amount >= $this->min_order_amount;
        }
        return true;
    }
}
