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
        return $this->belongsTo(OrderDistribution::class,'id');
    }
    public function cart(){
        return $this->belongsTo(AddToCart::class,'id');
    }
    public function pharmacy(){
        return $this->belongsTo(Pharmacy::class,'id');
    }
}
