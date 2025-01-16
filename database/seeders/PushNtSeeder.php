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
            'key' => 'payment',
            'name' => 'Payment {payment-status}',
            'variables' => json_encode([['key' => 'payment-id', 'meaning' => 'This is transaction ID'], ['key' => 'order-id', 'meaning' => 'This is order ID'], ['key' => 'payment-status', 'meaning' => 'This is payment status']]),
            'status' => 1,
        ]);
        NotificationTemplate::create([
            'key' => 'order',
            'name' => 'Order {order-status}',
            'variables' => json_encode([['key' => 'order-id', 'meaning' => 'This is order ID'], ['key' => 'order-status', 'meaning' => 'This is order status']]),
            'status' => 1,
        ]);
    }
}
