<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;

class Medicine extends BaseModel
{
    use HasFactory, SoftDeletes, Searchable;

    // protected $appends = ['final_discount'];

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
    public function active_discounts()
    {
        return $this->hasMany(Discount::class, 'pro_id', 'id')->where('status', 1);
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
        return $this->belongsToMany(MedicineUnit::class, 'medicine_unit_bkdns', 'medicine_id', 'unit_id')->withPivot('price');
    }
    public function strength()
    {
        return $this->belongsTo(MedicineStrength::class, 'strength_id');
    }
    public function dosage()
    {
        return $this->belongsTo(MedicineDose::class, 'dose_id');
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

    public function precaution():HasOne
    {
        return $this->hasOne(ProductPrecaution::class, 'product_id');
    }

    public function toSearchableArray():array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'generic_id' => optional($this->generic)->id,
            'generic_name' => optional($this->generic)->name,
            'generic_slug' => optional($this->generic)->slug,
            'company_id' => optional($this->company)->id,
            'company_name' => optional($this->company)->name,
            'company_slug' => optional($this->company)->slug,
            'strength' => optional($this->strength)->name,
            'category_id' => optional($this->pro_cat)->id,
            'category' => optional($this->pro_cat)->name,
            'sub_category_id' => optional($this->pro_sub_cat)->id,
            'sub_category' => optional($this->pro_sub_cat)->name,
            'price' => $this->price,
            'status' => $this->status,
            'best_selling' => $this->is_best_selling ? 'Bestselling' : 'No',
            'featured' => $this->is_featured ? 'Featured' : 'No',
            'image' => $this->image ? storage_url($this->image) : null,
            'units' => $this->units->pluck('name')->toArray(),
            'dose' => optional($this->dosage)->name,
        ];
    }

    public function isActived():bool
    {
        return $this->status == 1;
    }

    public function shouldBeSearchable(): bool
    {
        return $this->isActived();
    }

    // public function getFinalDiscountAttribute()
    // {
    //     $discounts = $this->discounts;

    //     if ($discounts->isEmpty()) {
    //         return 0;
    //     }

    //     $maxDiscount = $discounts->each(function ($discount) {
    //         if ($discount->discount_percentage) {
    //             return ($this->units->find($discount->unit_id)->price * $discount->discount_percentage) / 100;
    //         } elseif ($discount->discount_amount) {
    //             return $discount->discount_amount;
    //         }
    //         return 0;
    //     })->max();

    //     return $maxDiscount;
    // }
}
