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
    public function active_odps()
    {
        return $this->hasMany(OrderDistributionPharmacy::class, 'order_distribution_id', 'id')->where('status', 2)->latest();
    }
    public function odrs()
    {
        return $this->hasMany(OrderDistributionRider::class, 'order_distribution_id', 'id');
    }


    public function assignedRider()
    {
        return $this->hasMany(OrderDistributionRider::class, 'order_distribution_id')->where('status', '!=', -1)->latest();
    }

    public function disputedRiders()
    {
        return $this->hasMany(OrderDistributionRider::class, 'order_distribution_id')->where('status', -1);
    }

    public function otps()
    {
        return $this->hasMany(DistributionOtp::class, 'order_distribution_id');
    }

    public function active_otps()
    {
        return $this->hasMany(DistributionOtp::class, 'order_distribution_id')->where('status', 1)->latest();
    }

    public function delivery_otps()
    {
        return $this->hasMany(DeliveryOtp::class, 'order_distribution_id');
    }

    public function delivery_active_otps()
    {
        return $this->hasMany(DeliveryOtp::class, 'order_distribution_id')->where('status', 1)->latest();
    }

    public function getPharmacyStatus($pharmacy_id)
    {
        if ($this->odps->where('pharmacy_id', $pharmacy_id)->filter(function ($odp) {
            return $odp->status == 0 || $odp->status == 1;
        })->isEmpty()) {
            return 2;
        }else{
            return $this->status;
        }
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
                return 'badge bg-danger';
            case 3:
                return 'badge bg-secondary';
            case 4:
                return 'badge bg-primary';
            case 5:
                return 'badge bg-success';
            default:
                return 'badge bg-dark';

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
                return 'Assigned';
            case 4:
                return 'Picked-up';
            case 5:
                return 'Delivered';
            default:
                return 'Not-defined';
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
