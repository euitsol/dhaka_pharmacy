<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempUser extends BaseModel
{
    use HasFactory, SoftDeletes;

    public function messages()
    {
        return $this->morphMany(Message::class, 'sender');
    }
}