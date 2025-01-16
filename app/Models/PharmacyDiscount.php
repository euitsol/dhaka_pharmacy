<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PharmacyDiscount extends BaseModel
{
    use HasFactory, SoftDeletes;

    public function pharmacy(){
        return $this->belongsTo(Pharmacy::class,'pharmacy_id','id');
    }
}
