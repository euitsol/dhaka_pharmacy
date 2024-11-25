<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class Admin extends AuthenticateBaseModel
{
    use HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function identificationType()
    {
        switch ($this->identification_type) {
            case 1:
                return "National ID Card";
            case 2:
                return "Birth Certificate No";
            case 3:
                return "Passport No";
        }
    }
    public function getGender()
    {
        switch ($this->gender) {
            case 1:
                return "Male";
            case 2:
                return "Female";
            case 3:
                return "Other";
        }
    }
}