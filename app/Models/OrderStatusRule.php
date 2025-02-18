<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class OrderStatusRule extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'status_code',
        'status_name',
        'expected_time_interval',
        'expected_time_unit',
        'visible_to_user',
        'sort_order'
    ];

    public function getExpectedCompletionTime():Carbon|null
    {
        if (!$this->expected_time_interval) return null;

        return now()->add(
            $this->expected_time_unit,
            $this->expected_time_interval
        );
    }
}
