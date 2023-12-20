<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;

    public $guarded = [];
    public function created_user()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updated_user()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    public function deleted_user()
    {
        return $this->belongsTo(Admin::class, 'deleted_by');
    }
}
