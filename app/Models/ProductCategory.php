<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends BaseModel
{
    use HasFactory, SoftDeletes;

    public function pro_sub_cats()
    {
        return $this->hasMany(ProductSubCategory::class, 'pro_cat_id')->orderBy('name');
    }
    public function medicines()
    {
        return $this->hasMany(Medicine::class, 'pro_cat_id')->orderBy('name');
    }
}
