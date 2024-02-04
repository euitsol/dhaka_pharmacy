<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicine extends BaseModel
{
    use HasFactory, SoftDeletes;


    public function pro_cat()
    {
        return $this->belongsTo(ProductCategory::class, 'pro_cat_id');
    }
    public function generic()
    {
        return $this->belongsTo(GenericName::class, 'generic_id');
    }
    public function company()
    {
        return $this->belongsTo(CompanyName::class, 'company_id');
    }
    public function medicine_cat()
    {
        return $this->belongsTo(MedicineCategory::class, 'medicine_cat_id');
    }
    public function strength()
    {
        return $this->belongsTo(MedicineStrength::class, 'strength_id');
    }
}
