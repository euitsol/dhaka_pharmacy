<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDistributionPharmacy extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'order_distribution_id',
        'op_id',
        'pharmacy_id',
        'status',
        'updated_at'
    ];

    public function od()
    {
        return $this->belongsTo(OrderDistribution::class, 'order_distribution_id');
    }
    public function order_product()
    {
        return $this->belongsTo(OrderProduct::class, 'op_id');
    }
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id');
    }
    public function statusBg()
    {
        switch ($this->status) {
            case 0:
                return 'badge badge-info';
            case 1:
                return 'badge bg-secondary';
            case 2:
                return 'badge badge-primary';
            case 3:
                return 'badge badge-success';
            case -1:
                return 'badge badge-danger';
            default:
                return 'badge badge-dark';
        }
    }


    public function statusTitle()
    {
        switch ($this->status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Preparing';
            case 2:
                return 'Prepared';
            case 3:
                return 'Delivered';
            case -1:
                return 'Disputed';
            default:
                return 'Not-defined';
        }
    }
    public function pStatusSlug()
    {
        $status = $this->status;
        switch ($status) {
            case $status == 0 || $status == 1:
                return 'assigned';
                break;
            case $status == 2 || $status == 3:
                return 'prepared';
                break;
        }
    }
    public function pStatusTitle()
    {
        $status = $this->status;
        switch ($status) {
            case $status == 0:
                return 'assigned';
                break;
            case $status == 1:
                return 'assigned';
                break;
            case $status == 2:
                return 'prepared';
                break;
            case $status == 3:
                return 'delivered';
                break;
        }
    }
    public function pStatusBg()
    {
        $status = $this->status;
        switch ($status) {
            case $status == 0:
                return 'badge bg-secondary';
                break;
            case $status == 1:
                return 'badge bg-secondary';
                break;

            case $status == 2:
                return 'badge badge-primary';
                break;
            case $status == 3:
                return 'badge badge-success';
                break;
        }
    }
}