<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DistributionOtp extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'status',
        'rider_id',
        'order_distribution_id',
        'otp_author_id',
        'otp_author_type',
        'otp',
    ];
    public function od(){
        return $this->belongsTo(OrderDistribution::class,'order_distribution_id');
    }
    public function otp_author()
    {
        return $this->morphTo();
    }
}
