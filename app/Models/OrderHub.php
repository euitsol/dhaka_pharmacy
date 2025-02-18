<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderHub extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'hub_id',
        'status',
    ];

    protected $appends = [
        'status_string',
        'status_bg',
    ];

    public const ASSIGNED = 1;
    public const COLLECTING = 2;
    public const COLLECTED = 3;
    public const PREPARING = 4;
    public const PREPARED = 5;
    public const SHIPPED = 6;
    public const DELIVERED = 7;
    public const RETURNED = -1;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function hub(): BelongsTo
    {
        return $this->belongsTo(Hub::class, 'hub_id', 'id');
    }

    public function scopeOwnedByHub($query, $hubId)
    {
        return $query->where('hub_id', $hubId);
    }

    public function getStatusStringAttribute():string
    {
        return match($this->status) {
            self::ASSIGNED => 'Assigned',
            self::COLLECTING => 'Collecting',
            self::COLLECTED => 'Collected',
            self::PREPARING => 'Preparing',
            self::PREPARED => 'Prepared',
            self::SHIPPED => 'Shipped',
            self::DELIVERED => 'Delivered',
            self::RETURNED => 'Returned',
            default => 'Unknown Status',
        };
    }

    public function getStatusBgAttribute():string
    {
        return match($this->status) {
            self::ASSIGNED => 'bg-warning',
            self::COLLECTING => 'bg-info',
            self::COLLECTED => 'bg-info',
            self::PREPARING => 'bg-success',
            self::PREPARED => 'bg-success',
            self::SHIPPED => 'bg-success',
            self::DELIVERED => 'bg-success',
            self::RETURNED => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
