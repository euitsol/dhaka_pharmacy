<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Medicine extends BaseModel
{
    use HasFactory, SoftDeletes;


    public function pro_cat()
    {
        return $this->belongsTo(ProductCategory::class, 'pro_cat_id');
    }
    public function pro_sub_cat()
    {
        return $this->belongsTo(ProductSubCategory::class, 'pro_sub_cat_id');
    }
    public function generic()
    {
        return $this->belongsTo(GenericName::class, 'generic_id');
    }
    public function company()
    {
        return $this->belongsTo(CompanyName::class, 'company_id');
    }
    public function discounts()
    {
        return $this->hasMany(Discount::class, 'pro_id', 'id');
    }

    public function wish()
    {
        if (Auth::guard('web')->check()) {
            return $this->hasOne(WishList::class, 'product_id', 'id')
                ->where('user_id', user()->id);
        }
    }
    // public function medicine_cat()
    // {
    //     return $this->belongsTo(MedicineCategory::class, 'medicine_cat_id');
    // }
    public function strength()
    {
        return $this->belongsTo(MedicineStrength::class, 'strength_id');
    }

    public function getBestSelling()
    {
        if ($this->is_best_selling == 1) {
            return 'Yes';
        } else {
            return 'No';
        }
    }
    public function getBtnBestSelling()
    {
        if ($this->is_best_selling == 1) {
            return 'Remove from best selling';
        } else {
            return 'Make best selling';
        }
    }

    public function getBestSellingClass()
    {
        if ($this->is_best_selling == 1) {
            return 'btn-primary';
        } else {
            return 'btn-secondary';
        }
    }
    public function getBestSellingBadgeClass()
    {
        if ($this->is_best_selling == 1) {
            return 'badge badge-primary';
        } else {
            return 'badge badge-info';
        }
    }
    public function scopeBestSelling($query)
    {
        return $query->where('is_best_selling', 1);
    }

    function tipses()
    {
        return $this->hasMany(ProductTips::class, 'product_id');
    }
}
