<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderHubPharmacy extends BaseModel
{
    use HasFactory, SoftDeletes;

    public const ACTIVE = 1;
    public const COLLECTED = 2;
    public const PAID = 3;
    public const CANCELLED = -1;

    protected $fillable = [
        'order_id',
        'hub_id',
        'pharmacy_id',
        'total_payable_amount',
        'status'
    ];

    protected $appends = [
        'status_string',
        'status_bg'
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function products()
    {
        return $this->hasMany(OrderHubPharmacyProduct::class);
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

    public function scopeByHub($query, $hubId)
    {
        return $query->where('hub_id', $hubId);
    }

    public function scopeByPharmacy($query, $pharmacyId)
    {
        return $query->where('pharmacy_id', $pharmacyId);
    }

    // Accessors
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
