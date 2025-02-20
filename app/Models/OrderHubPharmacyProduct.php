<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderHubPharmacyProduct extends BaseModel
{
    use HasFactory, SoftDeletes;

    public const ACTIVE = 1;
    public const COLLECTED = 2;
    public const CANCELLED = -1;

    protected $fillable = [
        'order_hub_pharmacy_id',
        'order_product_id',
        'unit_payable_price',
        'quantity_collected',
        'status'
    ];

    protected $appends = [
        'total_collecting_amount',
        'status_string',
        'status_bg'
    ];

    // Relationships
    public function orderHubPharmacy()
    {
        return $this->belongsTo(OrderHubPharmacy::class);
    }

    public function orderProduct()
    {
        return $this->belongsTo(OrderProduct::class);
    }

    // Accessors
    public function getTotalCollectingAmountAttribute()
    {
        return $this->unit_payable_price * $this->quantity_collected;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', self::ACTIVE);
    }

    public function scopeCollected($query)
    {
        return $query->where('status', self::COLLECTED);
    }

    public function scopeByOrderHubPharmacy($query, $orderHubPharmacyId)
    {
        return $query->where('order_hub_pharmacy_id', $orderHubPharmacyId);
    }

    public function getStatusStringAttribute():string
    {
        return match($this->status) {
            self::ACTIVE => 'Active',
            self::COLLECTED => 'Collected',
            self::CANCELLED => 'Cancelled',
            default => 'Unknown Status',
        };
    }

    public function getStatusBgAttribute():string
    {
        return match($this->status) {
            self::ACTIVE => 'bg-warning',
            self::COLLECTED => 'bg-info',
            self::CANCELLED => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
