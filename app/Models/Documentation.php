<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documentation extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title', 
        'module_key', 
        'documentation',
        'created_by',
        'updated_by'
    ];
}
