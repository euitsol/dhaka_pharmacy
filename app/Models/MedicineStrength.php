<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MedicineStrength extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        'formatted_name',
    ];

    public function getFormattedNameAttribute()
    {
        return Str::limit($this->name, 20, '..');
    }
}
