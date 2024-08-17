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
    public function p_submitted_kyc(){
        return $this->hasOne(SubmittedKyc::class,'kyc_id')->where('creater_id', pharmacy()->id)->where('creater_type', get_class(pharmacy()));
    }
    public function r_submitted_kyc(){
        return $this->hasOne(SubmittedKyc::class,'kyc_id')->where('creater_id', rider()->id)->where('creater_type', get_class(rider()));
    }
    public function u_submitted_kyc(){
        return $this->hasOne(SubmittedKyc::class,'kyc_id')->where('creater_id', user()->id)->where('creater_type', get_class(user()));
    }
    public function dm_submitted_kyc(){
        return $this->hasOne(SubmittedKyc::class,'kyc_id')->where('creater_id', dm()->id)->where('creater_type', get_class(dm()));
    }
    public function lam_submitted_kyc(){
        return $this->hasOne(SubmittedKyc::class,'kyc_id')->where('creater_id', lam()->id)->where('creater_type', get_class(lam()));
    }
}
