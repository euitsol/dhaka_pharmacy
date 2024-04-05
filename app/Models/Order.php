<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends BaseModel
{
    use HasFactory, SoftDeletes;

    public function address(){
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function customer(){
        return $this->morphTo();
    }

    public function ref_user(){
        return $this->belongsTo(User::class, 'ref_user');
    }

    public function scopeStatus($query, $status){
        $db_status = ($status == 'success') ? 1 : (($status == 'pending') ? 0 : (($status == 'failed') ? -1 : (($status == 'cancel') ? -2 : 2)));
        return $query->where('status',$db_status);
    }
}
