<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipProduct extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'tips_id',
        'product_id',
        'created_by',
    ];
    function product()
    {
        return $this->belongsTo(Medicine::class, 'product_id');
    }
    function tips()
    {
        return $this->belongsTo(UserTips::class, 'tips_id');
    }
}
