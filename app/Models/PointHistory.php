<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PointHistory extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'eq_amount',
        'status',
        'created_by',
        'updated_by',
    ];
}
