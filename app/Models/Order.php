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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([OrderModelObserver::class])]
class Order extends BaseModel
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait;

    public const INITIATED = 0;
    public const SUBMITTED = 1;
    public const HUB_ASSIGNED = 2;
    public const ITEMS_COLLECTING = 3;
    public const HUB_REASSIGNED = 4;
    public const ITEMS_COLLECTED = 5;
    public const PACHAGE_PREPARED = 6;
    public const DISPATCHED = 7;
    public const DELIVERED = 8;
    public const CANCELLED = -1;
    public const RETURNED = -2;

    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_UNPAID = 'unpaid';
    public const PAYMENT_COD = 'cod';

    protected $fillable = [
        'order_id',
        'customer_id',
        'customer_type',
        'address_id',
        'voucher_id',
        'sub_total',
        'voucher_discount',
        'delivery_fee',
        'delivery_type',
        'product_discount',
        'status',
        'payment_status'
    ];

    protected $appends = [
        'status_string',
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

    public function productsWithHub()
    {
        return $this->belongsToMany(Medicine::class, 'order_products', 'order_id', 'product_id')
            ->using(OrderProduct::class)
            ->withPivot('id', 'unit_id', 'quantity', 'unit_price', 'unit_discount', 'total_price', 'status', 'medicine_units.name as pivot_unit_name', 'medicine_units.image as pivot_unit_image', 'medicine_units.status as pivot_unit_status', 'hubs.name as pivot_hub_name', 'hubs.id as pivot_hub_id')
            ->leftJoin('medicine_units', 'order_products.unit_id', '=', 'medicine_units.id')
            ->leftJoin('order_hub_products', 'order_hub_products.order_product_id', '=', 'order_products.id')
            ->leftJoin('order_hubs', 'order_hubs.id', '=', 'order_hub_products.order_hub_id')
            ->leftJoin('hubs', 'hubs.id', '=', 'order_hubs.hub_id');
    }

    public function productsWithHubPharmacy()
    {
        return $this->belongsToMany(Medicine::class, 'order_products', 'order_id', 'product_id')
            ->using(OrderProduct::class)
            ->withPivot(['id', 'unit_id', 'quantity', 'unit_price', 'unit_discount', 'total_price', 'status'])
            ->leftJoin('medicine_units', 'order_products.unit_id', '=', 'medicine_units.id')
            ->leftJoin('order_hub_products', function ($joinB) {
                $joinB->on('order_hub_products.order_product_id', '=', 'order_products.id');
            })
            ->leftJoin('order_hubs', function ($joinA) {
                $joinA->on('order_hub_products.order_hub_id', '=', 'order_hubs.id');
            })
            ->leftJoin('hubs', 'order_hubs.hub_id', '=', 'hubs.id')
            ->leftJoin('order_hub_pharmacy_products', function ($joinB) {
                $joinB->on('order_hub_pharmacy_products.order_product_id', '=', 'order_products.id');
            })
            ->leftJoin('order_hub_pharmacies', function ($joinA) {
                $joinA->on('order_hub_pharmacies.id', '=', 'order_hub_pharmacy_products.order_hub_pharmacy_id');
            })
            ->leftJoin('pharmacies', 'order_hub_pharmacies.pharmacy_id', '=', 'pharmacies.id')
            ->select([
                'medicines.*',
                'order_products.*',
                'medicine_units.name as pivot_unit_name',
                'hubs.name as pivot_hub_name',
                'hubs.id as pivot_hub_id',
                'pharmacies.name as pivot_pharmacy_name',
                'pharmacies.id as pivot_pharmacy_id',
                'order_hub_pharmacies.id as pivot_order_hub_pharmacy_id',
                'order_hub_pharmacies.total_payable_amount as pivot_order_hub_pharmacy_total_payable_amount',
            ]);
    }

    public function scopeInitiated($query)
    {
        return $query->where('status', 0);
    }

    public function scopeSelf($query, $user)
    {
        return $query->where('creater_type', get_class($user))
            ->where('creater_id', $user->id);
    }

    public function scopePaid($query)
    {
        return $query->whereHas('payments', function ($subQuery) {
            $subQuery->where('status', 1)->orWhere('payment_method', 'cod');
        });
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class);
    }

    public function timelines(): HasMany
    {
        return $this->hasMany(OrderTimeline::class, 'order_id', 'id');
    }

    public function getStatusStringAttribute(): string
    {
        return match ($this->status) {
            self::INITIATED => 'Initiated',
            self::SUBMITTED => 'Submitted',
            self::HUB_ASSIGNED => 'Hub Assigned',
            self::ITEMS_COLLECTING => 'Items Collecting',
            self::HUB_REASSIGNED => 'Hub Reassigned',
            self::ITEMS_COLLECTED => 'Items Collected',
            self::PACHAGE_PREPARED => 'Package Prepared',
            self::DISPATCHED => 'Dispatched',
            self::DELIVERED => 'Delivered',
            self::CANCELLED => 'Cancelled',
            self::RETURNED => 'Returned',
            default => 'Unknown Status',
        };
    }

    public function getStatusBg(): string
    {
        return match ($this->status) {
            self::INITIATED => 'bg-warning',
            self::SUBMITTED => 'bg-success',
            self::HUB_ASSIGNED => 'bg-info',
            self::ITEMS_COLLECTING => 'bg-info',
            self::HUB_REASSIGNED => 'bg-info',
            self::ITEMS_COLLECTED => 'bg-info',
            self::PACHAGE_PREPARED => 'bg-info',
            self::DISPATCHED => 'bg-info',
            self::DELIVERED => 'bg-info',
            self::CANCELLED => 'bg-danger',
            self::RETURNED => 'bg-danger',
            default => 'bg-secondary',
        };
    }

    public function hubs(): BelongsToMany
    {
        return $this->belongsToMany(Hub::class, 'order_hubs', 'order_id', 'hub_id')
            ->using(OrderHub::class)
            ->withPivot('status');
    }

    public function assignStatusToHubs(int $status)
    {
        foreach ($this->hubs as $hub) {
            $this->hubs()->updateExistingPivot($hub->id, ['status' => $status]);
        }
    }

    public function earnings()
    {
        return $this->morphMany(Earning::class, 'source');
    }
}
