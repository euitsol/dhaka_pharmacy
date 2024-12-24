<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends BaseModel
{
    use HasFactory, SoftDeletes;

    public function ticketable()
    {
        return $this->morphTo();
    }

    public function assigned_admin()
    {
        return $this->belongsTo(Admin::class);
    }
}