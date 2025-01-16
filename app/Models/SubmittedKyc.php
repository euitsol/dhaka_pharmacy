<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubmittedKyc extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $table = 'submitted_kycs';

    public function kyc()
    {
        return $this->belongsTo(KycSetting::class, 'kyc_id');
    }

    public function getStatus()
    {
        switch ($this->status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Verified';
            case -1:
                return 'Declined';
        }
    }
    public function getStatusBadgeClass()
    {
        switch ($this->status) {
            case 0:
                return 'badge badge-danger';
            case 1:
                return 'badge badge-success';
            case -1:
                return 'badge badge-info';
        }
    }
}
