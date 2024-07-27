<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Earning extends BaseModel
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'ph_id',
        'order_id',
        'point',
        'eq_amount',
        'activity',
        'description',
        'receiver_id',
        'receiver_type',
        'creater_id',
        'creater_type',
        'updater_id',
        'updater_type',
    ];
    public function withdraw_earning(): HasOne
    {
        return $this->hasOne(WithdrawEarning::class, 'e_id');
    }

    public function receiver()
    {
        return $this->morphTo();
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function point_history()
    {
        return $this->belongsTo(PointHistory::class, 'ph_id');
    }

    public function activityBg()
    {
        switch ($this->activity) {
            case 1:
                return 'badge badge-success';
            case 2:
                return 'badge badge-info';
            case 3:
                return 'badge badge-warning';
            case 4:
                return 'badge badge-primary';
            case 5:
                return 'badge badge-danger';
        }
    }

    public function activityTitle()
    {
        switch ($this->activity) {
            case 1:
                return 'Earning';
            case 2:
                return 'Withdrawn';
            case 3:
                return 'Pending clearance';
            case 4:
                return 'Pending withdrawn';
            case 5:
                return 'Withdrawn Declined';
        }
    }
    public function scopePharmacy($query)
    {
        return $query->where('receiver_id', pharmacy()->id)->where('receiver_type', get_class(pharmacy()));
    }
    public function scopeRider($query)
    {
        return $query->where('receiver_id', rider()->id)->where('receiver_type', get_class(rider()));
    }
    public function scopeLam($query)
    {
        return $query->where('receiver_id', lam()->id)->where('receiver_type', get_class(lam()));
    }
    public function scopeDm($query)
    {
        return $query->where('receiver_id', dm()->id)->where('receiver_type', get_class(dm()));
    }
}