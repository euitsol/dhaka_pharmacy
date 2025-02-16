<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'phone',
        'information',
        'status',
        'creater_id',
        'creater_type',
    ];

    protected $appends = [
        'status_string',
    ];

    public const STATUS_PENDING = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = -1;

    public function images(): HasMany
    {
        return $this->hasMany(PrescriptionImage::class);
    }

    public function getStatusStringAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            default => 'Unknown',
        };
    }


}
