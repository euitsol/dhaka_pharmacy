<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'product_id',
        'description',
        'status',
        'customer_id',
        'creater_id',
        'creater_type',
        'updater_id',
        'updater_type',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function product()
    {
        return $this->belongsTo(Medicine::class, 'product_id');
    }
}
