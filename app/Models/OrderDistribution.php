<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDistribution extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'order_id',
        'payment_type',
        'distribution_type',
        'prep_time',
        'note'
    ];

    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
    public function odps(){
        return $this->hasMany(OrderDistributionPharmacy::class,'order_distribution_id','id');
    }

    public function statusBg() {
        switch ($this->status) {
            case 0:
                return 'badge badge-success';
            case 1:
                return 'badge badge-info';
            case 2:
                return 'badge badge-warning';
            case 3:
                return 'badge badge-primary';
            case 4:
                return 'badge badge-secondary';
        }
    }
    
    public function statusTitle() {
        switch ($this->status) {
            case 0:
                return 'Distributed';
            case 1:
                return 'Preparing';
            case 2:
                return 'Waiting for pickup';
            case 3:
                return 'Picked up';
            case 4:
                return 'Finish';
        }
    }
    public function paymentType() {
        switch ($this->payment_type) {
            case 0:
                return 'Fixed Payment';
            case 1:
                return 'Open Payment';
        }
    }
    public function distributionType() {
        switch ($this->distribution_type) {
            case 0:
                return 'Normal Distribution';
            case 1:
                return 'Priority Distribution';
        }
    }

    public function readablePrepTime(){
        $duration = Carbon::parse($this->prep_time)->diff(Carbon::parse($this->created_at));
        $formattedDuration = '';
        if ($duration->h > 0) {
            $formattedDuration .= $duration->h . ' hours ';
        }
        if ($duration->i > 0) {
            $formattedDuration .= $duration->i . ' minutes';
        }
        return $formattedDuration;
    }
    public function prepTotalSeconds(){
        $duration = Carbon::parse($this->prep_time)->diff(Carbon::parse($this->created_at));
        $totalSeconds = $duration->s + ($duration->i * 60) + ($duration->h * 3600) + ($duration->days * 86400);
        return $totalSeconds;
    }
    
}
