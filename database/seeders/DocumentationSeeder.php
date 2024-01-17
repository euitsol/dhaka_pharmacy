<?php

namespace Database\Seeders;

use App\Models\Documentation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $module_keys = ['admin','user','pharmacy','permission','roll','pharmacy_kyc_settings'];

        foreach($module_keys as $key){
            Documentation::create([
                'module_key' => $key,
            ]);
        }
        
    }
}
