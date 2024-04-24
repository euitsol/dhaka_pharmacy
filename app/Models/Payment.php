<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends BaseModel
{
    use HasFactory, SoftDeletes;

    public function customer(){
        return $this->morphTo();
    }
    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function scopeStatus($query, $status){
        $db_status = ($status == 'success') ? 1 : (($status == 'pending') ? 0 : (($status == 'failed') ? -1 : (($status == 'cancel') ? -2 : 2)));
        return $query->where('status',$db_status);
    }

    // public function scopeStatus($query, $status){
    //     $db_status = ($status == 'success') ? 2 : (($status == 'pending') ? 1 : (($status == 'initiated') ? 0 : (($status == 'failed') ? -1 : (($status == 'cancel') ? -2 : 3))));
    //     return $query->where('status',$db_status);
    // }
}
