<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends AuthenticateBaseModel
{
    use HasRoles, HasApiTokens, Notifiable;
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


    public function messages()
    {
        return $this->morphMany(Message::class, 'sender');
    }

    public function addToCart():MorphMany
    {
        return $this->morphMany(AddToCart::class, 'creater');
    }
}
