<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempFile extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'filename',
        'path',
        'creater_id',
        'creater_type',
    ];
}
