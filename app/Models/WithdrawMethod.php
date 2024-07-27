<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawMethod extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'bank_name',
        'bank_brunch_name',
        'routing_number',
        'account_name',
        'type',
        'note',
        'creater_id',
        'creater_type',
        'updater_id',
        'updater_type',
    ];

    public function type()
    {
        switch ($this->type) {
            case 0:
                return 'Personal';
            case 1:
                return 'Business';
        }
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
                return 'Verified';
            case 2:
                return 'Declined';
        }
    }
    public function scopeStatus($query, $status)
    {
        switch ($status) {
            case 'pending':
                $status = 0;
                break;
            case 'verified':
                $status = 1;
                break;
            case 'declined':
                $status = 2;
                break;
        }
        return $query->where('status', $status);
    }
    public function scopePharmacy($query)
    {
        return $query->where('creater_id', pharmacy()->id)->where('creater_type', get_class(pharmacy()));
    }
    public function scopeRider($query)
    {
        return $query->where('creater_id', rider()->id)->where('creater_type', get_class(rider()));
    }
    public function scopeLam($query)
    {
        return $query->where('creater_id', lam()->id)->where('creater_type', get_class(lam()));
    }
    public function scopeDm($query)
    {
        return $query->where('creater_id', dm()->id)->where('creater_type', get_class(dm()));
    }
}