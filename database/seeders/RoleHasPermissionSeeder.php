<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleHasPermissionSeeder extends Seeder
{
    public function run(): void
    {

        $superAdminPermissons = [
            5 => 1,
            6 => 1,
            7 => 1,
            8 => 1,
        ];
        $adminPermissons = [
            5 => 2,
            6 => 2,
            7 => 2,
            8 => 2,
        ];

        foreach ($superAdminPermissons as $permission_id => $role_id) {
            DB::table('role_has_permissions')->insert([
                'permission_id' => $permission_id,
                'role_id' => $role_id,
            ]);
        }
        foreach ($adminPermissons as $permission_id => $role_id) {
            DB::table('role_has_permissions')->insert([
                'permission_id' => $permission_id,
                'role_id' => $role_id,
            ]);
        }
    }
}

