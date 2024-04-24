<?php

namespace App\Models;

class Pharmacy extends AuthenticateBaseModel
{
    protected $fillable = [
        'name',
        'email',
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

    public function operation_area()
    {
        return $this->belongsTo(OperationArea::class, 'oa_id');
    }
    public function operation_sub_area()
    {
        return $this->belongsTo(OperationSubArea::class, 'osa_id');
    }
}
