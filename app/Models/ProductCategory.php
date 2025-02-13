<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProductCategory extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        'formatted_name',
    ];

    public function getFormattedNameAttribute()
    {
        return Str::limit($this->name, 20, '..');
    }

    public function pro_sub_cats()
    {
        return $this->hasMany(ProductSubCategory::class, 'pro_cat_id')->orderBy('name');
    }
    public function medicines()
    {
        return $this->hasMany(Medicine::class, 'pro_cat_id')->orderBy('name');
    }
}
