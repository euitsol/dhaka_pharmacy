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

    public function getKycStatus()
    {
        if ($this->kyc_status == 1) {
            return 'Complete';
        } else {
            return 'Pending';
        }
    }
    public function getKycStatusClass()
    {
        if ($this->kyc_status == 1) {
            return 'badge badge-info';
        } else {
            return 'badge badge-warning';
        }
    }
    public function getPhoneVerifyStatus()
    {
        if ($this->is_verify == 1) {
            return 'Success';
        } else {
            return 'Pending';
        }
    }
    public function getPhoneVerifyClass()
    {
        if ($this->is_verify == 1) {
            return 'badge badge-primary';
        } else {
            return 'badge badge-dark';
        }
    }
}
