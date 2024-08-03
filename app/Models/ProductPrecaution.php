<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrecaution extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'status',
        'product_id',
    ];
    public function product()
    {
        return $this->belongsTo(Medicine::class, 'product_id');
    }
}
