<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteSetting extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['key', 'value', 'env_key'];
    public $guarded = [];
}
