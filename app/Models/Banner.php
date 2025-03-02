<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;

class Banner extends BaseModel
{
    use HasFactory, SoftDeletes;

    public const ACTIVE = 1;
    public const INACTIVE = 0;
    public const MOBILE = 1;
    public const DESKTOP = 0;

    protected $fillable = [
        'title',
        'link',
        'image_path',
        'page_key',
        'status',
        'is_mobile',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $casts = [
        'is_mobile' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', self::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::INACTIVE);
    }

    public function scopeMobile($query)
    {
        return $query->where('is_mobile', self::MOBILE);
    }

    public function getImagePathAttribute($image_path)
    {
        return banner_image($image_path);
    }
}
