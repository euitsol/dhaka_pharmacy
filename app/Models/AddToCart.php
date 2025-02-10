<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddToCart extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'customer_id',
        'unit_id',
        'quantity',
        'status',
        'creater_id',
        'creater_type'
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

    public function scopeCurrentCart($query, Authenticatable $user){
        return $query->where('creater_id', $user->id)->where('creater_type', get_class($user))->where('status', 1);
    }
}
