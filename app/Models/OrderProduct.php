<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Pivot
{

    use HasFactory, SoftDeletes;
    protected $table = 'order_products';

    protected $fillable = [
        'order_id',
        'product_id',
        'unit_id',
        'quantity',
        'unit_price',
        'unit_discount',
        'total_price',
        'status'
    ];
    public function unit()
    {
        return $this->belongsTo(MedicineUnit::class, 'unit_id');
    }
    public function product()
    {
        return $this->belongsTo(Medicine::class, 'product_id');
    }
}
