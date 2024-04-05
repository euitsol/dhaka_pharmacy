<?php

namespace Database\Seeders;

use App\Models\NotificationTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PushNtSeeder extends Seeder
{
    public function run(): void
    {
        NotificationTemplate::create([
            'key' => 'payment_success',
            'name' => 'Payment Success',
            'variables'=>json_encode([['key'=>'payment-id','meaning'=>'This is payment ID'],['key'=>'order-id','meaning'=>'This is order ID'],['key'=>'amount','meaning'=>'This is payment amount']]),
            'status' => 1,
        ]);
        NotificationTemplate::create([
            'key' => 'payment_faild',
            'name' => 'Payment Faild',
            'variables'=>json_encode([['key'=>'payment-id','meaning'=>'This is payment ID'],['key'=>'order-id','meaning'=>'This is order ID'],['key'=>'amount','meaning'=>'This is payment amount']]),
            'status' => 1,
        ]);
        NotificationTemplate::create([
            'key' => 'payment_pending',
            'name' => 'Payment Pending',
            'variables'=>json_encode([['key'=>'payment-id','meaning'=>'This is payment ID'],['key'=>'order-id','meaning'=>'This is order ID'],['key'=>'amount','meaning'=>'This is payment amount']]),
            'status' => 1,
        ]);
        NotificationTemplate::create([
            'key' => 'order_initialized',
            'name' => 'Order Created',
            'variables'=>json_encode([['key'=>'order-id','meaning'=>'This is order ID']]),
            'status' => 1,
        ]);
        NotificationTemplate::create([
            'key' => 'order_delivered',
            'name' => 'Order Delivered',
            'variables'=>json_encode([['key'=>'product-title','meaning'=>'This is product title']]),
            'status' => 1,
        ]);
    }
}
