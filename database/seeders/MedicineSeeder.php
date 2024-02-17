<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i<=20; $i++){
            Medicine::create([
                'name' => 'Chaney Martinez'.$i,
                'slug' => 'chaney-martinez'.$i,
                'pro_cat_id' => 2,
                'pro_sub_cat_id' => 2,
                'generic_id' => 1,
                'company_id' => 1,
                'medicine_cat_id' => 2,
                'strength_id' => 11,
                'unit' => json_encode(["10","3"]),
                'price' => 141,
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                'prescription_required' => NULL,
                'max_quantity' => NULL,
                'kyc_required' => NULL,
                'status' => 1,
                'is_best_selling' => 1,
            ]);
        }
        
    }
}
