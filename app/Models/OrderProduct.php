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
    public function unit()
    {
        return $this->belongsTo(MedicineUnit::class, 'unit_id');
    }
}
