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
                return 'badge badge-danger';
            case 3:
                return 'badge bg-info';
            case 4:
                return 'badge badge-primary';
            case 5:
                return 'badge badge-dark';
            case 6:
                return 'badge badge-success';
            case 7:
                return 'badge badge-danger';
            case 8:
                return 'badge badge-warning';
        }
    }
    
    
    public function statusTitle() {
        switch ($this->status) {
            case 0:
                return 'dispute';
            case 3:
                return 'ongoing';
            case 4:
                return 'collect';
            case 5:
                return 'delivered';
            case 6:
                return 'complete';
            case 7:
                return 'Cancel';
            case 8:
                return 'Cancel Complete';
        }
    }

}
