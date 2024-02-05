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

    

}
