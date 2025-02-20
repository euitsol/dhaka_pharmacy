<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderHub extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'hub_id',
        'status',
    ];

    protected $appends = [
        'status_string',
        'status_bg',
    ];

    public const ASSIGNED = Order::HUB_ASSIGNED;
    public const COLLECTING = Order::ITEMS_COLLECTING;
    public const COLLECTED = Order::ITEMS_COLLECTED;
    public const PREPARED = Order::PACHAGE_PREPARED;
    public const DISPATCHED = Order::DISPATCHED;
    public const DELIVERED = Order::DELIVERED;
    public const RETURNED = Order::RETURNED;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function orderhubproducts()
    {
        return $this->belongsToMany(OrderProduct::class, 'order_hub_products', 'order_hub_id', 'order_product_id')
            ->withPivot('status')
            ->with('product.pro_cat')
            ->join('medicine_units', 'order_products.unit_id', '=', 'medicine_units.id')
            ->leftJoin('order_hub_pharmacy_products', function($joinA) {
                $joinA->on('order_hub_pharmacy_products.order_product_id', '=', 'order_products.id');
            })
            ->leftJoin('order_hub_pharmacies', function($joinB) {
                $joinB->on('order_hub_pharmacies.id', '=', 'order_hub_pharmacy_products.order_hub_pharmacy_id');
            })
            ->leftJoin('pharmacies', 'order_hub_pharmacies.pharmacy_id', '=', 'pharmacies.id')
            ->select([
                'order_products.id',
                'order_products.quantity',
                'order_products.product_id',
                'medicine_units.name as pivot_unit_name',
                'pharmacies.name as pivot_pharmacy_name',
                'pharmacies.id as pivot_pharmacy_id',
            ]);
    }

    public function hub(): BelongsTo
    {
        return $this->belongsTo(Hub::class, 'hub_id', 'id');
    }

    // public function getPharmacyProductsWithCollectedQuantity()
    // {
    //     return $this->hasMany(OrderHubPharmacy::class, 'hub_id', 'id') // Relation from OrderHub to OrderHubPharmacy via hub_id (and implicitly order_id if needed, but based on table structure, hub_id seems primary for filtering within hub context)
    //         ->select([
    //             'order_hub_pharmacies.*', // Select all columns from order_hub_pharmacies
    //             'ohpp.order_product_id as ohpp_order_product_id', // Alias for clarity
    //             'ohpp.quantity_collected as ohpp_quantity_collected', // Alias for clarity
    //             'op.product_id as op_product_id' // For product info if needed
    //         ])
    //         ->join('order_hub_pharmacy_products as ohpp', 'order_hub_pharmacies.id', '=', 'ohpp.order_hub_pharmacy_id')
    //         ->join('order_products as op', 'ohpp.order_product_id', '=', 'op.id');
    // }

    public function scopeOwnedByHub($query)
    {
        return $query->where('hub_id', staff()->hub_id);
    }

    public function getStatusStringAttribute():string
    {
        return match($this->status) {
            self::ASSIGNED => 'Assigned',
            self::COLLECTING => 'Collecting',
            self::COLLECTED => 'Collected',
            self::PREPARED => 'Prepared',
            self::DISPATCHED => 'Dispatched',
            self::DELIVERED => 'Delivered',
            self::RETURNED => 'Returned',
            default => 'Unknown Status',
        };
    }

    public function getStatusBgAttribute():string
    {
        return match($this->status) {
            self::ASSIGNED => 'bg-warning',
            self::COLLECTING => 'bg-info',
            self::COLLECTED => 'bg-info',
            self::PREPARED => 'bg-success',
            self::DISPATCHED => 'bg-success',
            self::DELIVERED => 'bg-success',
            self::RETURNED => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
