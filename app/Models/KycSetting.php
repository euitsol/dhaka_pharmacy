<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KycSetting extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'type',
        'status',
        'form_data',
        'created_by',
        'updated_by'
    ];

    public function submitted_kycs(){
        return $this->hasMany(SubmittedKyc::class,'kyc_id');
    }
}
