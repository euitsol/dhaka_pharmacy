<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SslCommerzSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = ['store_id'=>'SSLCZ_STORE_ID','store_password'=>'SSLCZ_STORE_PASSWORD','test_mode'=>'SSLCZ_TESTMODE'];
        
        
        foreach($datas as $key=>$env_key){
            PaymentGateway::create([
                'key' => $key,
                'env_key' => $env_key,
            ]);
        }
    }
}
