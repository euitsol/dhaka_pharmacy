<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['message', 'sender_id', 'sender_type', 'ticket_id'];

    protected $appends = ['author_image', 'send_at'];

    public function sender()
    {
        return $this->morphTo();
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', 0);
    }
    public function scopeRead($query)
    {
        return $query->where('is_read', 1);
    }

    public function getAuthorImageAttribute()
    {
        return $this->sender->image ? asset('storage/' . $this->sender->image) : asset('default_img/male.png');
    }

    public function getSendAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}