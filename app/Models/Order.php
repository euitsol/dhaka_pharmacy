<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;

class Order extends BaseModel
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait;
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
        // $status = ($status == 'success') ? 2 : (($status == 'pending') ? 1 : (($status == 'initiated') ? 0 : (($status == 'failed') ? -1 : (($status == 'cancel') ? -2 : 3))));

        switch ($status) {
            case 'initiated':
                $status = 0;
                break;
            case 'submitted':
                $status = 1;
                break;
            case 'processed':
                $status = 2;
                break;
            case 'waiting-for-rider':
                $status = 3;
                break;
            case 'assigned':
                $status = 4;
                break;
            default:
                $status =  'Unknown';
                break;
        }
        return $query->where('status', $status);
    }

    public function od(): HasOne
    {
        return $this->hasOne(OrderDistribution::class);
    }


    public function statusBg()
    {
        switch ($this->status) {
            case 0:
                return 'badge bg-secondary';
            case 1:
                return 'badge badge-info';
            case 2:
                return 'badge badge-warning';
            case 3:
                return 'badge badge-danger';
            case 4:
                return 'badge badge-success';
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
                return 'Submitted';
            case 2:
                return 'Processed';
            case 3:
                return 'Waiting-for-rider';
            case 4:
                return 'Assigned';
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

    public function products()
    {
        return $this->belongsToMany(Medicine::class, 'order_products', 'order_id', 'product_id')
            ->using(OrderProduct::class)
            ->withPivot('id', 'unit_id', 'quantity');
    }

    public function scopeInitiated($query)
    {
        return $query->where('status', 0);
    }

    public function scopeSelf($query)
    {
        return $query->where('creater_type', User::class)
            ->where('creater_id', user()->id);
    }

    /**
     * Scope to filter orders where at least one payment is paid.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->whereHas('payments', function ($subQuery) {
            $subQuery->where('status', 1)->orWhere('payment_method', 'cod');
        });
    }
}
