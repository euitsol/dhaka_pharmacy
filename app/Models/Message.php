<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['message', 'sender_id', 'sender_type', 'ticket_id'];

    public function sender()
    {
        return $this->morphTo();
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
