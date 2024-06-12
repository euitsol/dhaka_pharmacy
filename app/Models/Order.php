<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'status',
        'address_id',
        'ref_user',
        'carts',
        'status',
        'payment_getway',
        'order_id',
        'promo_code',
        'delivery_fee',
        'delivery_type',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function customer()
    {
        return $this->morphTo();
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id', 'id');
    }

    public function ref_user()
    {
        return $this->belongsTo(User::class, 'ref_user');
    }
    public function obp()
    {
        return $this->belongsTo(OrderPrescription::class, 'obp_id');
    }

    public function scopeStatus($query, $status)
    {
        $db_status = ($status == 'success') ? 2 : (($status == 'pending') ? 1 : (($status == 'initiated') ? 0 : (($status == 'failed') ? -1 : (($status == 'cancel') ? -2 : 3))));
        return $query->where('status', $db_status);
    }

    public function od(): HasOne
    {
        return $this->hasOne(OrderDistribution::class);
    }


    public function statusBg()
    {
        switch ($this->status) {
            case 0:
                return 'badge badge-secondary';
            case 1:
                return 'badge badge-info';
            case 2:
                return 'badge badge-success';
            case -1:
                return 'badge badge-danger';
            case -2:
                return 'badge badge-warning';
            case -3:
                return 'badge badge-dark';
            default:
                return 'badge badge-primary';
        }
    }

    public function statusTitle()
    {
        switch ($this->status) {
            case 0:
                return 'Initiated';
            case 1:
                return 'Pending';
            case 2:
                return 'Success';
            case -1:
                return 'Failed';
            case -2:
                return 'Cancel';
            case -3:
                return 'Distributed';
            default:
                return 'Processing';
        }
    }
    public function orderType()
    {
        return $this->obp_id != null ? 'Order By Prescription' : 'Manual Order';
    }
}
