<?php

namespace App\Models;

use App\Observers\AddressObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([AddressObserver::class])]
class Address extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'creater_id',
        'creater_type',
        'updater_id',
        'updater_type',
        'deleter_id',
        'deleter_type',
        'name',
        'phone',
        'city',
        'street_address',
        'latitude',
        'longitude',
        'apartment',
        'floor',
        'delivery_instruction',
        'address',
        'is_default',
        'zone_id',
        'is_express',
    ];

    public function getFeaturedStatus()
    {
        if ($this->is_default == 1) {
            return 'Default';
        } else {
            return 'Not Default';
        }
    }
    public function getFeaturedBadgeClass()
    {
        if ($this->is_default == 1) {
            return 'badge bg-success';
        } else {
            return 'badge bg-info';
        }
    }
    public function zone():BelongsTo
    {
        return $this->belongsTo(DeliveryZone::class);
    }
}
