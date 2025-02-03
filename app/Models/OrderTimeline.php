<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderTimeline extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'status',
        'expected_completion_time',
        'actual_completion_time'
    ];

    protected $appends = ['status_string'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function statusRule(): BelongsTo
    {
        return $this->belongsTo(OrderStatusRule::class, 'status', 'status_code');
    }

    public function getStatusStringAttribute()
    {
        if (!$this->relationLoaded('statusRule')) {
            return $this->statusRule()->first()->status_name;
        }
        return $this->statusRule->status_name;
    }
}
