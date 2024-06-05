<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WishList extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $table = 'wishlists';
    protected $fillable = [
        'user_id',
        'product_id',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Medicine::class, 'product_id');
    }
}
