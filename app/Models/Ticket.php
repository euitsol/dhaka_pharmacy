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
        return $this->hasMany(Message::class, 'ticket_id', 'id');
    }

    public function assignedAdmin()
    {
        return $this->belongsTo(Admin::class, 'assigned_admin');
    }

    public function getStatus()
    {
        switch ($this->status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Opened';
            case 2:
                return 'Closed';
        }
    }
    public function getStatusBadgeClass()
    {
        switch ($this->status) {
            case 0:
                return 'badge badge-info';
            case 1:
                return 'badge badge-success';
            case 2:
                return 'badge badge-danger';
        }
    }
}
