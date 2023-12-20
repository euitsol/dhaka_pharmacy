<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            1 => 'superadmin',
            2 => 'admin',
        ];

        foreach ($roles as $roleId => $roleName) {
            Role::create(['id' => $roleId,'name' => $roleName,'guard_name'=>'admin']);
        }

        // Create Superadmin
        $superadmin = Admin::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@euitsols.com',
            'password' => Hash::make('superadmin@euitsols.com'),
            'role_id' => 1,
        ]);
        $superadmin->assignRole($superadmin->role->name);

        // Create Admin
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@euitsols.com',
            'password' => Hash::make('admin@euitsols.com'),
            'role_id' => 2,
        ]);
        $admin->assignRole($admin->role->name);
    }
}
