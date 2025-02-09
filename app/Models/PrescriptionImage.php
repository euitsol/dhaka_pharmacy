<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrescriptionImage extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'prescription_id',
        'path',
        'status',
        'creater_id',
        'creater_type',
    ];

    protected $appends = [
        'status_string',
    ];

    public const PENDING = 0;
    public const SAVED = 1;
    public const CANCELLED = -1;

    public function getStatusStringAttribute()
    {
        return match ($this->status) {
            self::PENDING => 'Pending',
            self::SAVED => 'Saved',
            self::CANCELLED => 'Cancelled',
            default => 'Unknown',
        };
    }

    public function prescription(): BelongsTo
    {
        return $this->belongsTo(Prescription::class);
    }
}
