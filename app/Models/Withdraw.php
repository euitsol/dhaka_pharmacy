<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdraw extends BaseModel
{
    use HasFactory, SoftDeletes;
    public function earning(){
        return $this->belongsTo(Earning::class,'earning_id');
    }
    public function withdraw_method(){
        return $this->belongsTo(WithdrawMethod::class,'wm_id');
    }
    public function receiver()
    {
        return $this->morphTo();
    }
}
