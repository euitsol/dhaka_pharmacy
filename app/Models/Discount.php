<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends BaseModel
{
    use HasFactory, SoftDeletes;
    public function product()
    {
        return $this->belongsTo(Medicine::class, 'pro_id');
    }
}
