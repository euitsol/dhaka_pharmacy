<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDistributionPharmacy extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'order_distribution_id',
        'op_id',
        'pharmacy_id',
        'status'
    ];

    public function od()
    {
        return $this->belongsTo(OrderDistribution::class, 'order_distribution_id');
    }
    public function order_product()
    {
        return $this->belongsTo(OrderProduct::class, 'op_id');
    }
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id');
    }
    public function statusBg()
    {
        switch ($this->status) {
            case 0:
                return 'badge badge-info';
            case 1:
                return 'badge bg-secondary';
            case 2:
                return 'badge badge-primary';
            case 3:
                return 'badge badge-warning';
            case 4:
                return 'badge badge-dark';
            case 5:
                return 'badge badge-success';
            case 6:
                return 'badge badge-danger';
            case -1:
                return 'badge badge-danger';
        }
    }


    public function statusTitle()
    {
        switch ($this->status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Preparing';
            case 2:
                return 'Waiting for Rider';
            case 3:
                return 'Dispute';
            case 4:
                return 'Picked Up';
            case 5:
                return 'Delivered';
            case 7:
                return 'Cancel';
            case -1:
                return 'Old Disputed';
        }
    }
}
