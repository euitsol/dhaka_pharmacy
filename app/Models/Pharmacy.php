<?php

namespace App\Models;

class Pharmacy extends AuthenticateBaseModel
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'oa_id',
        'osa_id',
        'kyc_status',
        'email_verified_at',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function identificationType()
    {
        if ($this->identification_type == 1) {
            return 'TIN Certificate';
        } elseif ($this->identification_type == 2) {
            return 'Trade License';
        }
    }
    public function operation_area()
    {
        return $this->belongsTo(OperationArea::class, 'oa_id');
    }
    public function operation_sub_area()
    {
        return $this->belongsTo(OperationSubArea::class, 'osa_id');
    }

    public function odps()
    {
        return $this->hasMany(OrderDistributionPharmacy::class, 'pharmacy_id', 'id');
    }

    public function pharmacyDiscounts()
    {
        return $this->hasMany(PharmacyDiscount::class, 'pharmacy_id');
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'creater');
    }
}
