<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = [
            1 => 'superadmin',
            2 => 'admin',
            3 => 'user',
        ];

        foreach ($roles as $roleId => $roleName) {
            Role::create(['id' => $roleId,'name' => $roleName]);
        }

        // Create Superadmin
        $superadmin = User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@dev.com',
            'password' => Hash::make('superadmin@dev.com'),
            'role_id' => 1,
        ]);
        $superadmin->assignRole($superadmin->role->name);

        // Create Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@dev.com',
            'password' => Hash::make('admin@dev.com'),
            'role_id' => 2,
        ]);
        $admin->assignRole($admin->role->name);

        // Create User
        $user = User::create([
            'name' => 'User',
            'email' => 'user@dev.com',
            'password' => Hash::make('user@dev.com'),
            'role_id' => 3,
        ]);
        $user->assignRole($user->role->name);

    }
}