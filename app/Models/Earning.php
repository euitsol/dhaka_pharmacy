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
            case -1:
                return 'badge bg-secondary';
            case 0:
                return 'badge badge-warning';
            case 1:
                return 'badge badge-success';
            case 2:
                return 'badge badge-primary';
            case 3:
                return 'badge badge-info';
            case 4:
                return 'badge badge-danger';
        }
    }
    public function activityTitle()
    {
        switch ($this->activity) {
            case -1:
                return 'Payment-declined';
            case 0:
                return 'Pending-clearance';
            case 1:
                return 'Earning';
            case 2:
                return 'Pending-withdraw';
            case 3:
                return 'Withdraw';
            case 4:
                return 'Withdraw-declined';
        }
    }

    public function scopeActivity($query, $activity)
    {
        switch ($activity) {
            case 'Payment-declined':
                $activity = -1;
                break;
            case 'Pending-clearance':
                $activity = 0;
                break;
            case 'Earning':
                $activity = 1;
                break;
            case 'Pending-withdraw':
                $activity = 2;
                break;
            case 'Withdraw':
                $activity = 3;
                break;
            case 'Withdraw-declined':
                $activity = 4;
                break;
        }
        return $query->where('activity', $activity);
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
