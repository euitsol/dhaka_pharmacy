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
        'cart_id',
        'pharmacy_id'
    ];

    public function od(){
        return $this->belongsTo(OrderDistribution::class,'order_distribution_id');
    }
    public function cart(){
        return $this->belongsTo(AddToCart::class,'cart_id');
    }
    public function pharmacy(){
        return $this->belongsTo(Pharmacy::class,'pharmacy_id');
    }
    public function statusBg() {
        switch ($this->status) {
            case 0:
                return 'badge badge-warning';
            case 1:
                return 'badge badge-info';
            case 2:
                return 'badge badge-danger';
        }
    }
    
    public function statusTitle() {
        switch ($this->status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Distributed';
            case 2:
                return 'Dispute';
        }
    }
}
