<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddToCart extends BaseModel
{
    use HasFactory, SoftDeletes;

    public function product(){
        return $this->belongsTo(Medicine::class,'product_id');
    }
    public function customer(){
        return $this->belongsTo(User::class,'customer_id');
    }
    public function unit(){
        return $this->belongsTo(MedicineUnit::class,'unit_id');
    }
}
