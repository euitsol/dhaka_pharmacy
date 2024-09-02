<?php

namespace Database\Seeders;

use App\Models\OperationArea;
use App\Models\OperationSubArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperationalAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Operational Area
        OperationArea::create([
            'name' => 'Mirpur',
            'slug' => 'mirpur',
        ]);
        OperationArea::create([
            'name' => 'Gulshan',
            'slug' => 'gulshan',
        ]);



        // Operational Sub Area
        OperationSubArea::create([
            'name' => 'Mirpur-1',
            'slug' => 'mirpur-1',
            'oa_id' => 1,
        ]);
        OperationSubArea::create([
            'name' => 'Mirpur-2',
            'slug' => 'mirpur-2',
            'oa_id' => 1,
        ]);
        OperationSubArea::create([
            'name' => 'Mirpur-6',
            'slug' => 'mirpur-6',
            'oa_id' => 1,
        ]);
        OperationSubArea::create([
            'name' => 'Mirpur-7',
            'slug' => 'mirpur-7',
            'oa_id' => 1,
        ]);
        OperationSubArea::create([
            'name' => 'Mirpur-10',
            'slug' => 'mirpur-10',
            'oa_id' => 1,
        ]);
        OperationSubArea::create([
            'name' => 'Mirpur-11',
            'slug' => 'mirpur-11',
            'oa_id' => 1,
        ]);
        OperationSubArea::create([
            'name' => 'Mirpur-12',
            'slug' => 'mirpur-12',
            'oa_id' => 1,
        ]);
        OperationSubArea::create([
            'name' => 'Mirpur-13',
            'slug' => 'mirpur-13',
            'oa_id' => 1,
        ]);
        OperationSubArea::create([
            'name' => 'Mirpur-14',
            'slug' => 'mirpur-14',
            'oa_id' => 1,
        ]);
        OperationSubArea::create([
            'name' => 'Gulshan-1',
            'slug' => 'gulshan-1',
            'oa_id' => 2,
        ]);
        OperationSubArea::create([
            'name' => 'Gulshan-2',
            'slug' => 'gulshan-2',
            'oa_id' => 2,
        ]);
        OperationSubArea::create([
            'name' => 'Gulshan-3',
            'slug' => 'gulshan-3',
            'oa_id' => 2,
        ]);
        OperationSubArea::create([
            'name' => 'Gulshan-4',
            'slug' => 'gulshan-4',
            'oa_id' => 2,
        ]);
        OperationSubArea::create([
            'name' => 'Gulshan-5',
            'slug' => 'gulshan-5',
            'oa_id' => 2,
        ]);
    }
}