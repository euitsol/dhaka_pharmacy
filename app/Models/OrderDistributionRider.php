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

    public function statusBg()
    {
        switch ($this->status) {
            case 0:
                return 'badge badge-success';
            case 1:
                return 'badge bg-warning';
            case 2:
                return 'badge badge-primary';
            case 3:
                return 'badge badge-dark';
            default:
                return 'badge badge-secondary';
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
                return 'delivered';
            default:
                return 'not defined';
        }
    }
}
