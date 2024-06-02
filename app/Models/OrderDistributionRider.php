<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDistributionRider extends BaseModel
{
    use HasFactory, SoftDeletes;
    public function od(){
        return $this->belongsTo(OrderDistribution::class,'order_distribution_id');
    }
    public function rider(){
        return $this->belongsTo(Rider::class,'rider_id');
    }
    public function priority(){
        switch($this->priority){
            case 0:
                return "Normal";
            case 1:
                return "Medium";
            case 2:
                return "High";
        }
    }
    public function statusBg() {
        switch ($this->status) {
            case 0:
            case -1:
                return 'badge badge-danger';
            case 1:
                return 'badge bg-info';
            case 2:
                return 'badge badge-primary';
            case 3:
                return 'badge badge-dark';
            case 4:
                return 'badge badge-success';
            case 5:
                return 'badge badge-danger';
        }
    }
    public function statusTitle() {
        switch ($this->status) {
            case 0:
            case -1:
                return 'dispute';
            case 1:
                return 'waiting-for-pickup';
            case 2:
                return 'picked-up';
            case 3:
                return 'delivered';
            case 4:
                return 'finish';
            case 5:
                return 'cancel';
        }
    }

}
