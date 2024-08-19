<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryOtp extends BaseModel
{
    use HasFactory, SoftDeletes;

    public function od(){
        return $this->belongsTo(OrderDistribution::class,'order_distribution_id');
    }

    public function rider(){
        return $this->belongsTo(Rider::class,'rider_id');
    }
    public function customer(){
        return $this->belongsTo(User::class,'user_id');
    }
}
