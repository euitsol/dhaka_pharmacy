<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Medicine extends BaseModel
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait;


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
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }
    public function self_review()
    {
        return $this->hasOne(Review::class, 'product_id', 'id')
            ->where('customer_id', auth()->id());
    }

    public function wish($user_id = null)
    {
        return $this->hasOne(WishList::class, 'product_id', 'id')
            ->when($user_id, function ($query, $user_id) {
                $query->where('user_id', $user_id)->where('status', 1);
            });
    }
    public function units()
    {
        return $this->belongsToMany(MedicineUnit::class, 'medicine_unit_bkdns', 'medicine_id', 'unit_id');
    }
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
        return $this->hasMany(TipProduct::class, 'product_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products', 'medicine_id', 'order_id')->withPivot('unit_id', 'quantity');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('pro_cat_id', $categoryId);
    }


    public function scopeBySubCategory($query, $scategoryId)
    {
        return $query->where('pro_sub_cat_id', $scategoryId);
    }

    public function precaution()
    {
        return $this->hasOne(ProductPrecaution::class, 'product_id');
    }
}
