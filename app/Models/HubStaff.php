<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HubStaff extends AuthenticateBaseModel
{
    use HasFactory, SoftDeletes;

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_OTHER = 3;

    protected $casts = [
        'gender' => 'integer',
        'status' => 'boolean',
        'is_verify' => 'boolean'
    ];

    protected $fillable = [
        'hub_id',
        'name',
        'phone',
        'emergency_phone',
        'email',
        'password',
        'image',
        'bio',
        'is_verify',
        'email_verified_at',
        'otp',
        'age',
        'gender',
        'remember_token',
    ];


    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }
}
