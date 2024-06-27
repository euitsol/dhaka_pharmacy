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

    public function statusBg() {
        switch ($this->status) {
            case 0:
                return 'badge bg-info';
            case 1:
                return 'badge bg-success';
            case -1:
                return 'badge bg-warning';
            case -2:
                return 'badge bg-danger';
            default:
                return 'badge bg-primary';
        }
    }
    public function statusTitle() {
        switch ($this->status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Success';
            case -1:
                return 'Failed';
            case -2:
                return 'Cancel';
            default:
                return 'Processing';
        }
    }

}