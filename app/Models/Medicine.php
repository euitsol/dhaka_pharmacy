<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

class Medicine extends BaseModel
{
    use HasFactory, SoftDeletes, Searchable;

    // protected $appends = ['final_discount'];

    protected $fillable = [
        'name',
        'slug',
        'generic_id',
        'pro_cat_id',
        'pro_sub_cat_id',
        'company_id',
        'strength_id',
        'price',
        'image',
        'description',
        'status',
        'is_best_selling',
        'is_featured',
        'prescription_required',
        'kyc_required',
        'max_quantity',
        'created_by',
        'updated_by',
        'use_for',
        'dar'

    ];
    protected $appends = [
        'modified_image',
        'discount_amount',
        'discount_percentage',
        'discounted_price',
        'strength_info',
        'company_info',
        'generic_info',
        'attr_title',
        'formatted_name',
        'formatted_sub_cat',
        'is_tba',
        'is_orderable'
    ];

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
            return 'Remove from medical device';
        } else {
            return 'Make medical device';
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

    public function precaution(): HasOne
    {
        return $this->hasOne(ProductPrecaution::class, 'product_id');
    }

    public function toSearchableArray(): array
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

    public function searchableAs()
    {
        return 'medicines';
    }

    public function isActived(): bool
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

    public function getModifiedImageAttribute()
    {
        return $this->image ? product_image($this->image) : null;
    }

    public function getDiscountAmountAttribute(): int|float
    {
        if (!$this->relationLoaded('discounts')) {
            $this->load('discounts');
        }

        $discount = $this->discounts()->where('status', 1)->first();

        if (!$discount) {
            return 0.00;
        }

        if (!empty($discount->discount_percentage)) {
            return $this->price * ($discount->discount_percentage / 100);
        } elseif (!empty($discount->discount_amount)) {
            return $discount->discount_amount;
        }

        return 0.00;
    }

    public function getDiscountedPriceAttribute(): int|float
    {
        $discounted_price = $this->price - $this->discount_amount;
        if ($discounted_price > 0) {
            return $discounted_price;
        }
        return 0.00;
    }

    public function getDiscountPercentageAttribute(): float
    {
        if ($this->price > 0) {
            return ($this->discount_amount / $this->price) * 100;
        }
        return 0.00;
    }

    public function getImageAttribute($image): string
    {
        return product_image($image);
    }

    public function getStrengthInfoAttribute(): string
    {
        return $this->strength ? Str::limit($this->strength->name, 20, '..') : '';
    }
    public function getCompanyInfoAttribute(): string
    {
        return $this->company ? Str::limit($this->company->name, 20, '..') : '';
    }

    public function getGenericInfoAttribute(): string
    {
        return $this->generic ? Str::limit($this->generic->name, 20, '..') : '';
    }

    public function getAttrTitleAttribute($name): string
    {
        return Str::ucfirst(Str::title($name));
    }

    public function getFormattedNameAttribute(): string
    {
        return Str::limit(Str::ucfirst(Str::lower($this->name . ($this->strength_info))), 24, '..');
    }

    public function getFormattedSubCatAttribute(): string
    {
        return $this->pro_sub_cat ? Str::limit($this->pro_sub_cat->name, 24, '..') : '';
    }
    public function getIsTbaAttribute(): bool
    {
        if (!$this->relationLoaded('units')) {
            $this->load('units');
        }
        if ($this->price <= 0 || ($this->units->isEmpty())) {
            return true;
        }

        return false;
    }

    public function getIsOrderableAttribute(): bool
    {
        if ($this->is_tba || ($this->prescription_required == true)) {
            return false;
        }
        return true;
    }
}
