<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPrescription extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'status',
        'order_id',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'obp_id');
    }

    public function statusBg()
    {
        switch ($this->status) {
            case 0:
                return 'badge badge-info';
            case 1:
                return 'badge bg-success';
            case 2:
                return 'badge badge-danger';
        }
    }
    public function statusTitle()
    {
        switch ($this->status) {
            case 0:
                return 'pending';
            case 1:
                return 'ordered';
            case 2:
                return 'cancel';
        }
    }
}
