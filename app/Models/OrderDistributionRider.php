<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDistributionRider extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'status',
    ];
    public function od()
    {
        return $this->belongsTo(OrderDistribution::class, 'order_distribution_id');
    }
    public function rider()
    {
        return $this->belongsTo(Rider::class, 'rider_id');
    }
    public function priority()
    {
        switch ($this->priority) {
            case 0:
                return "Normal";
            case 1:
                return "Medium";
            case 2:
                return "High";
        }
    }

    public function scopeStatus($query, $status)
    {
        switch ($status) {
            case 'dispute':
                $status = 0;
                break;
            case 'assigned':
                $status = 1;
                break;
            case 'picking-up':
                $status = 2;
                break;
            case 'picked-up':
                $status = 3;
                break;
            case 'delivering':
                $status = 4;
                break;
            case 'delivered':
                $status = 5;
                break;
            default:
                $status =  '';
                break;
        }
        $query->where('status', $status);
        if ($status == 0) {
            $query->orWhere('status', -1);
        }
        return $query;
    }
    public function statusBg()
    {
        switch ($this->status) {
            case 0:
                return 'badge badge-secondary';
            case 1:
                return 'badge bg-warning';
            case 2:
                return 'badge badge-primary';
            case 3:
                return 'badge badge-dark';
            case 4:
                return 'badge badge-info';
            case 5:
                return 'badge badge-success';
        }
    }
    public function statusTitle()
    {
        switch ($this->status) {
            case 0:
                return 'assigned';
            case 1:
                return 'picking-up';
            case 2:
                return 'picked-up';
            case 3:
                return 'picked-up';
            case 4:
                return 'delivering';
            case 5:
                return 'delivered';
        }
    }
}
