<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends BaseModel
{
    use HasFactory, SoftDeletes;
    public function openedBy()
    {
        return $this->belongsTo(Admin::class, 'opened_by');
    }

    public function getStatus()
    {
        if ($this->status == 1) {
            return 'New';
        } else {
            return '';
        }
    }
    public function getStatusBg()
    {
        if ($this->status == 1) {
            return 'badge badge-primary';
        } else {
            return '';
        }
    }
}
