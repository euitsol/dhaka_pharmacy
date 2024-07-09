<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PointSetting extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'key',
        'value',
        'status',
        'created_by',
        'updated_by',
    ];
}