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

    public function orderHub(): BelongsTo
    {
        return $this->belongsTo(OrderHub::class, 'order_hub_id', 'id');
    }

    public function orderProduct(): BelongsTo
    {
        return $this->belongsTo(OrderProduct::class, 'order_product_id', 'id');
    }
}
