<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class DistrictManager extends AuthenticateBaseModel
{
    use HasRoles;

    protected $fillable = [
        'name',
        'phone',
        'password',
        'oa_id',
        'kyc_status',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function lams()
    {
        return $this->hasMany(LocalAreaManager::class, 'dm_id');
    }
    public function operation_area()
    {
        return $this->belongsTo(OperationArea::class, 'oa_id');
    }

    public function earnings()
    {
        return $this->morphMany(Earning::class, 'receiver');
    }
}
