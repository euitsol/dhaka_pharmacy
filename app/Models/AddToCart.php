<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddToCart extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'status',
        'unit_id',
        'quantity',
    ];


    public function product(){
        return $this->belongsTo(Medicine::class,'product_id');
    }
    public function customer(){
        return $this->belongsTo(User::class,'customer_id');
    }
    public function unit(){
        return $this->belongsTo(MedicineUnit::class,'unit_id');
    }
    public function odps(){
        return $this->hasMany(OrderDistributionPharmacy::class,'cart_id','id');
    }
    public function scopeCheck($query){
        return $query->where('is_check',1);
    }

    public function scopeCurrentCart($query){
        if (user()) {
            return $query->where('customer_id', user()->id)
                ->where('status', 1);
        }

        return $query;
    }
}
