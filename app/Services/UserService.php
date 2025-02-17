<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\{DB, Log};


class UserService
{
    public function __construct()
    {

    }

    public function createUser(array $data):User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'] ?? 'Unknown User',
                'phone' => $data['phone']
            ]);
            return $user;
        });
    }
}
