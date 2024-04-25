<?php

namespace App\Models;

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
        'note'
    ];

    public function order(){
        return $this->belongsTo(Order::class,'id');
    }
    public function odps(){
        return $this->hasMany(OrderDistributionPharmacy::class,'order_distribution_id','id');
    }

    public function statusBg() {
        switch ($this->status) {
            case 0:
                return 'badge badge-success';
            case 1:
                return 'badge badge-info';
            case 2:
                return 'badge badge-warning';
            case 3:
                return 'badge badge-primary';
            case 4:
                return 'badge badge-secondary';
            default:
                return 'badge badge-danger';
        }
    }
    
    public function statusTitle() {
        switch ($this->status) {
            case 0:
                return 'Distributed';
            case 1:
                return 'Preparing';
            case 2:
                return 'Waiting for pickup';
            case 3:
                return 'Picked up';
            case 4:
                return 'Finish';
            default:
                return 'Not Distributed';
        }
    }
    
}
