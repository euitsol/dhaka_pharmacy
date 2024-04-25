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
    
}
