<?php

namespace Database\Seeders;

use App\Models\GenericName;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineGenericSeeder extends Seeder
{
    public function run(): void
    {
        GenericName::create([
            'name' => 'FLUOXETINE',
            'slug' => 'FLUOXETINE',
            ]);
        GenericName::create([
            'name' => 'SODIUM VALPROATE+VALPORIC ACID',
            'slug' => 'SODIUM-VALPROATE+VALPORIC-ACID',
            ]);
        GenericName::create([
            'name' => 'MIDAZOLAM',
            'slug' => 'MIDAZOLAM',
            ]);
        GenericName::create([
            'name' => 'LUBRICATING',
            'slug' => 'LUBRICATING',
            ]);
        GenericName::create([
            'name' => 'ARIPIPRAZOLE',
            'slug' => 'ARIPIPRAZOLE',
            ]);
    }
}
