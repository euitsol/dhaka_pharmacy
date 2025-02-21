<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'invoice',
        'order_id',
        'payload',
        'response',
        'status_code',
        'receiver_id',
        'receiver_type',
        'address_id',
        'sent_at',
        'received_at',
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
}
