<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDistribution extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'order_id',
        'payment_type',
        'distribution_type',
        'prep_time',
        'note',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function odps()
    {
        return $this->hasMany(OrderDistributionPharmacy::class, 'order_distribution_id', 'id');
    }
    public function odrs()
    {
        return $this->hasMany(OrderDistributionRider::class, 'order_distribution_id', 'id');
    }
    public function odr()
    {
        return $this->hasMany(OrderDistributionRider::class, 'order_distribution_id', 'id')->where('status', 1);
    }

    public function statusBg()
    {
        switch ($this->status) {
            case 0:
                return 'badge bg-info';
            case 1:
                return 'badge bg-warning';
            case 2:
                return 'badge bg-secondary';
            case 3:
                return 'badge bg-danger';
            case 4:
                return 'badge bg-primary';
            case 5:
                return 'badge bg-dark';
            case 6:
                return 'badge bg-success';
            case 7:
                return 'badge bg-danger';

        }
    }

    public function statusTitle() {
        switch ($this->status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Preparing';
            case 2:
                return 'Prepared';
            case 3:
                return 'Waiting-for-pickup';
            case 4:
                return 'Picked-up';
            case 5:
                return 'Delivered';
            case 6:
                return 'Finish';
            case 7:
                return 'Cancel';
            }
    }

    public function paymentType()
    {
        switch ($this->payment_type) {
            case 0:
                return 'Fixed Payment';
            case 1:
                return 'Open Payment';
        }
    }
    public function distributionType()
    {
        switch ($this->distribution_type) {
            case 0:
                return 'Normal Distribution';
            case 1:
                return 'Priority Distribution';
        }
    }
}
