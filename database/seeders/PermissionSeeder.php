<?php

namespace Database\Seeders;

use App\Models\Permission;
use League\Csv\Reader;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $csvFile = public_path('csv/permissions.csv');

        $csv = Reader::createFromPath($csvFile, 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            Permission::create($record);
        }
    }
}