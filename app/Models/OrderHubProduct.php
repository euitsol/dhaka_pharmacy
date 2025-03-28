<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderHubProduct extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_hub_id',
        'order_product_id',
        'status',
    ];

    protected $appends = [
        'status_string',
    ];
    public const ACTIVE = 1;
    public const INACTIVE = 0;

    public function orderHub(): BelongsTo
    {
        return $this->belongsTo(OrderHub::class, 'order_hub_id', 'id');
    }

    public function orderProduct(): BelongsTo
    {
        return $this->belongsTo(OrderProduct::class, 'order_product_id', 'id');
    }

    public function getStatusStringAttribute()
    {
        return $this->status == self::ACTIVE ? 'Active' : 'Inactive';
    }
}
