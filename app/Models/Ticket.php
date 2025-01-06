<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['subject', 'status', 'ticketable_id', 'ticketable_type', 'assigned_admin'];

    public function ticketable()
    {
        return $this->morphTo();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
