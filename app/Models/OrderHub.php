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

    public const ASSIGNED = 1;
    public const RETURNED = -1;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function hub(): BelongsTo
    {
        return $this->belongsTo(Hub::class, 'hub_id', 'id');
    }
}
