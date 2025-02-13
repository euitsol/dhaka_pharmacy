<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MedicineUnit extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        'formatted_name',
    ];

    public function getFormattedNameAttribute()
    {
        return Str::limit($this->name, 20, '..');
    }

    public function getImageAttribute($value):string
    {
        return storage_url($value);
    }
}
