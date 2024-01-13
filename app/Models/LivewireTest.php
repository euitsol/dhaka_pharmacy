<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LivewireTest extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 
        'roll',
        'created_by',
        'updated_by'
    ];
}
