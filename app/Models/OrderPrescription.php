<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPrescription extends BaseModel
{
    use HasFactory, SoftDeletes;

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function statusBg()
    {
        switch ($this->status) {
            case 0:
                return 'badge badge-danger';
            case 1:
                return 'badge bg-info';
            case 2:
                return 'badge badge-primary';
            case 3:
                return 'badge badge-dark';
        }
    }
    public function statusTitle()
    {
        switch ($this->status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Ordered';
            case 2:
                return 'Disclosed';
            case 3:
                return 'Cancel';
        }
    }
}
