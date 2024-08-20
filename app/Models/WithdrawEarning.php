<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class WithdrawEarning extends Pivot
{
    use HasFactory, SoftDeletes;
    protected $table = 'withdraw_earnings';
    public function withdraw()
    {
        return $this->belongsTo(Withdraw::class, 'w_id');
    }
    public function earning()
    {
        return $this->belongsTo(Earning::class, 'e_id');
    }
    public function creater()
    {
        return $this->morphTo();
    }
    public function updater()
    {
        return $this->morphTo();
    }
    public function deleter()
    {
        return $this->morphTo();
    }
}
