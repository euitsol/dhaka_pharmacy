<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KycSetting extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'type',
        'status',
        'form_data'
    ];
}
