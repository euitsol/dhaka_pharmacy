<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperationArea extends BaseModel
{
    use HasFactory, SoftDeletes;
    public function operation_sub_areas()
    {
        return $this->hasMany(OperationSubArea::class, 'oa_id')->orderBy('name');
    }
}
