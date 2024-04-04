<?php

namespace Database\Seeders;

use App\Models\NotificationSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PushNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = ['app_id'=>'PUSHER_APP_ID','key'=>'PUSHER_APP_KEY','secret'=>'PUSHER_APP_SECRET','cluster'=>'PUSHER_APP_CLUSTER','instance_id'=>'PUSHER_INSTANCE_ID','primary_key'=>'PUSHER_PRIMARY_KEY'];

        foreach($datas as $key=>$env_key){
            NotificationSetting::create([
                'key' => $key,
                'env_key' => $env_key,
            ]);
        }
        
       
    }
}
