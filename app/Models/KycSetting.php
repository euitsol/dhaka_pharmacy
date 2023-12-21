<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KycSetting extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'type', // Add 'type' to the fillable property
        'status',
        'form_data',
        // Add other fields that can be mass assigned if necessary
    ];
}
