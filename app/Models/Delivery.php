<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends BaseModel
{
    use HasFactory, SoftDeletes;

    public const STATUS_ACTIVE = 1;
    public const STATUS_CANCELED = -1;
    protected $fillable = [
        'type',
        'invoice',
        'order_id',
        'hub_id',
        'payload',
        'response',
        'status_code',
        'receiver_id',
        'receiver_type',
        'address_id',
        'sent_at',
        'received_at',
        'tracking_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'creater_id',
        'creater_type',
        'updater_id',
        'updater_type',
        'deleter_id',
        'deleter_type'
    ];

    protected $appends = [
        'status_string',
        'status_color',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function getStatusStringAttribute()
    {
        if ($this->status === self::STATUS_ACTIVE) {
            return 'Active';
        } elseif ($this->status === self::STATUS_CANCELED) {
            return 'Canceled';
        }
        return 'Unknown';
    }

    public function getStatusColorAttribute()
    {
        if ($this->status === self::STATUS_ACTIVE) {
            return 'success';
        } elseif ($this->status === self::STATUS_CANCELED) {
            return 'danger';
        }
        return 'warning';
    }

}
