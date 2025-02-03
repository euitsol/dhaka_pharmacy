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
        'is_verify' => 'boolean',
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
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

    protected $appends = [
        'gender_label'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }


    public function setGenderAttribute($value)
    {
        $validGenders = [self::GENDER_MALE, self::GENDER_FEMALE, self::GENDER_OTHER];
        if (!in_array($value, $validGenders)) {
            throw new \InvalidArgumentException("Invalid gender value. Allowed values are: " . implode(', ', $validGenders));
        }
        $this->attributes['gender'] = $value;
    }

    public static function getGenderOptions()
    {
        return [
            self::GENDER_MALE => 'Male',
            self::GENDER_FEMALE => 'Female',
            self::GENDER_OTHER => 'Other',
        ];
    }
    public function getGenderLabelAttribute()
    {
        $genderOptions = self::getGenderOptions();
        return $genderOptions[$this->gender] ?? 'Unknown';
    }
}
