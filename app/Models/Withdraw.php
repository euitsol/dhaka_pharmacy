<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdraw extends BaseModel
{
    use HasFactory, SoftDeletes;
    public function withdraw_method()
    {
        return $this->belongsTo(WithdrawMethod::class, 'wm_id');
    }
    public function receiver()
    {
        return $this->morphTo();
    }

    public function earnings()
    {
        return $this->belongsToMany(Earning::class, 'withdraw_earnings', 'w_id', 'e_id')
            ->using(WithdrawEarning::class)
            ->withPivot('id');
    }
    public function statusBg()
    {
        switch ($this->status) {
            case 0:
                return 'badge bg-info';
            case 1:
                return 'badge badge-success';
            case 2:
                return 'badge badge-danger';
        }
    }

    public function statusTitle()
    {
        switch ($this->status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Complete';
            case 2:
                return 'Declained';
        }
    }
    public function scopeStatus($query, $status)
    {
        switch ($status) {
            case 'Pending':
                $status = 0;
                break;
            case 'Complete':
                $status = 1;
                break;
            case 'Declained':
                $status = 2;
                break;
        }
        return $query->where('status', $status);
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
