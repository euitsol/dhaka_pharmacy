<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Observers\OrderModelObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// #[ObservedBy([OrderModelObserver::class])]
class Order extends BaseModel
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait;
    protected $fillable = [
        'order_id',
        'customer_id',
        'customer_type',
        'address_id',
        'voucher_id',
        'sub_total',
        'voucher_discount',
        'delivery_fee',
        'product_discount',
        'status'
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

    // public function ref_user()
    // {
    //     return $this->belongsTo(User::class, 'ref_user');
    // }
    public function obp()
    {
        return $this->belongsTo(OrderPrescription::class, 'obp_id');
    }
    public function deliveryType()
    {
        switch ($this->delivery_type) {
            case 0:
                return 'Normal';
            case 1:
                return 'Standard';
        }
    }

    public function od(): HasOne
    {
        return $this->hasOne(OrderDistribution::class);
    }

    public function orderType()
    {
        return $this->obp_id != null ? 'Order By Prescription' : 'Manual Order';
    }

    public function products()
    {
        // return $this->belongsToMany(Medicine::class, 'order_products', 'order_id', 'product_id')
        //     ->using(OrderProduct::class)
        //     ->withPivot('id', 'unit_id', 'quantity', 'unit_price','unit_discount', 'total_price', 'status');


        return $this->belongsToMany(Medicine::class, 'order_products', 'order_id', 'product_id')
        ->using(OrderProduct::class)
        ->withPivot('id', 'unit_id', 'quantity', 'unit_price', 'unit_discount', 'total_price', 'status', 'medicine_units.name as pivot_unit_name', 'medicine_units.image as pivot_unit_image', 'medicine_units.status as pivot_unit_status')
        ->leftJoin('medicine_units', 'order_products.unit_id', '=', 'medicine_units.id');
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

    public function scopePaid($query)
    {
        return $query->whereHas('payments', function ($subQuery) {
            $subQuery->where('status', 1)->orWhere('payment_method', 'cod');
        });
    }

    public function voucher():BelongsTo
    {
        return $this->belongsTo(Voucher::class);
    }
}
