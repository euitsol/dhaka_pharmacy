<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPrescription extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'address_id',
        'order_id',
        'status',
        'delivery_type',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function statusBg()
    {
        switch ($this->status) {
            case 0:
                return 'badge badge-info';
            case 1:
                return 'badge bg-success';
            case 2:
                return 'badge badge-warning';
            case 3:
                return 'badge badge-danger';
        }
    }
    public function statusTitle()
    {
        switch ($this->status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Ordered';
            case 2:
                return 'Disclosed';
            case 3:
                return 'Cancel';
        }
    }
}
