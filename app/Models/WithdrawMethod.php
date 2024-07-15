<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawMethod extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'bank_name',
        'bank_brunch_name',
        'routing_number',
        'account_name',
        'type',
        'creater_id',
        'creater_type'
    ];

    public function statusBg()
    {
        switch ($this->status) {
            case 0:
                return 'badge bg-info';
            case 1:
                return 'badge badge-success';
            case 2:
                return 'badge badge-danger';
        }
    }

    public function statusTitle()
    {
        switch ($this->status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Verified';
            case 2:
                return 'Declained';
        }
    }
}
