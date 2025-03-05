<?php

namespace Database\Seeders;

use App\Models\Permission;
use League\Csv\Reader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Clear the permission tables
        Permission::query()->delete();
        DB::table('model_has_permissions')->delete();
        DB::table('role_has_permissions')->delete();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $csvFile = public_path('csv/permissions.csv');

        $csv = Reader::createFromPath($csvFile, 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            Permission::firstOrCreate(
                ['name' => $record['name'], 'guard_name' => $record['guard_name']],
                $record
            );
        }
    }
}
