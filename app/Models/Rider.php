<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rider extends AuthenticateBaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'phone',
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

    public function operation_area()
    {
        return $this->belongsTo(OperationArea::class, 'oa_id');
    }
    public function operation_sub_area()
    {
        return $this->belongsTo(OperationSubArea::class, 'osa_id');
    }
}
