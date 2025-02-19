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

    public const ASSIGNED = Order::HUB_ASSIGNED;
    public const COLLECTING = Order::ITEMS_COLLECTING;
    public const COLLECTED = Order::ITEMS_COLLECTED;
    public const PREPARED = Order::PACHAGE_PREPARED;
    public const DISPATCHED = Order::DISPATCHED;
    public const DELIVERED = Order::DELIVERED;
    public const RETURNED = Order::RETURNED;

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
            self::PREPARED => 'Prepared',
            self::DISPATCHED => 'Dispatched',
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
            self::PREPARED => 'bg-success',
            self::DISPATCHED => 'bg-success',
            self::DELIVERED => 'bg-success',
            self::RETURNED => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
