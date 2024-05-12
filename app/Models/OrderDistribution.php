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

    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
    public function odps(){
        return $this->hasMany(OrderDistributionPharmacy::class,'order_distribution_id','id');
    }

    public function statusBg() {
        switch ($this->status) {
            case 0:
                return 'badge badge-info';
            case 1:
                return 'badge badge-warning';
            case 2:
                return 'badge bg-secondary';
            case 3:
                return 'badge badge-danger';
            case 4:
                return 'badge badge-primary';
            case 5:
                return 'badge badge-success';
                
        }
    }
    
    public function statusTitle() {
        switch ($this->status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Preparing';
            case 2:
                return 'Waiting for rider';
            case 3:
                return 'Waiting for pickup';
            case 4:
                return 'Picked up';
            case 5:
                return 'Finish';
        }
    }
    public function paymentType() {
        switch ($this->payment_type) {
            case 0:
                return 'Fixed Payment';
            case 1:
                return 'Open Payment';
        }
    }
    public function distributionType() {
        switch ($this->distribution_type) {
            case 0:
                return 'Normal Distribution';
            case 1:
                return 'Priority Distribution';
        }
    }
    
}
