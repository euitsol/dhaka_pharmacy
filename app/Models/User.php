<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends AuthenticateBaseModel
{
    use HasRoles, HasApiTokens;
    protected $fillable = [
        'name',
        'email',
        'password',
        'oa_id',
        'osa_id',
        'status',
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

    public function address()
    {
        return $this->morphMany(Address::class, 'creater');
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
