<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubmittedKyc extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $table = 'submitted_kycs';
}
