<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pro_id',
        'discount_amount',
        'discount_percentage',
        'status'
    ];
    public function product()
    {
        return $this->belongsTo(Medicine::class, 'pro_id');
    }
}
