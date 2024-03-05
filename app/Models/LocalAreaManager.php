<?php

namespace App\Models;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class LocalAreaManager extends AuthenticateBaseModel
{
    use HasRoles;
    protected $fillable = [
        'name',
        'phone',
        'password',
        'dm_id',
        'osa_id',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function dm()
    {
        return $this->belongsTo(DistrictManager::class, 'dm_id');
    }
    public function operation_sub_area()
    {
        return $this->belongsTo(OperationSubArea::class, 'osa_id');
    }
}
