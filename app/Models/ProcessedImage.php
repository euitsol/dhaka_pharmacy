<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcessedImage extends BaseModel
{
    public const STATUS_PENDING = 0;
    public const STATUS_PROCESSED = 1;
    public const STATUS_PROCESSING = 2;
    public const STATUS_FAILED = -1;

    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'backup_path',
        'new_path',
        'metadata',
        'processed_at',
        'is_processed',
        'status',
    ];

    protected $casts = [
        'metadata' => 'array',
        'processed_at' => 'datetime',
    ];

    protected $appends = [
        'image_url',
        'status_name',
        'status_color',
    ];

    public function medicine():BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }

    public function getImageUrlAttribute()
    {
        return storage_url($this->image_path);
    }

    public function getStatusNameAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSED => 'Processed',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_FAILED => 'Failed',
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_PROCESSED => 'success',
            self::STATUS_PROCESSING => 'info',
            self::STATUS_FAILED => 'danger',
        };
    }
}
