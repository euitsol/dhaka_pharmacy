<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends BaseModel
{
    use HasFactory, SoftDeletes;

    public function getFeaturedStatus()
    {
        if ($this->is_default == 1) {
            return 'Default';
        } else {
            return 'Not Default';
        }
    }
    public function getFeaturedBadgeClass()
    {
        if ($this->is_default == 1) {
            return 'badge bg-success';
        } else {
            return 'badge bg-info';
        }
    }
}
