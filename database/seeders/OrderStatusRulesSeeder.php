<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderStatusRule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // OrderStatusRule::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $statusRules = [
            // Visible to users
            [
                'status_code' => Order::INITIATED,
                'status_name' => 'Order Initiated',
                'expected_time_interval' => null,
                'expected_time_unit' => null,
                'visible_to_user' => true,
                'sort_order' => 1
            ],
            [
                'status_code' => Order::SUBMITTED,
                'status_name' => 'Submitted',
                'expected_time_interval' => null,
                'expected_time_unit' => null,
                'visible_to_user' => true,
                'sort_order' => 2
            ],
            [
                'status_code' => Order::HUB_ASSIGNED,
                'status_name' => 'Hub Assigned',
                'expected_time_interval' => null,
                'expected_time_unit' => null,
                'visible_to_user' => false,
                'sort_order' => 3
            ],
            [
                'status_code' => Order::ITEMS_COLLECTING,
                'status_name' => 'Items Collecting',
                'expected_time_interval' => null,
                'expected_time_unit' => null,
                'visible_to_user' => false,
                'sort_order' => 4
            ],
            [
                'status_code' => Order::HUB_REASSIGNED,
                'status_name' => 'Reassigned hub',
                'expected_time_interval' => null,
                'expected_time_unit' => null,
                'visible_to_user' => false,
                'sort_order' => 5
            ],
            [
                'status_code' => Order::ITEMS_COLLECTED,
                'status_name' => 'Items Collected',
                'expected_time_interval' => null,
                'expected_time_unit' => null,
                'visible_to_user' => false,
                'sort_order' => 6
            ],
            [
                'status_code' => Order::PACHAGE_PREPARED,
                'status_name' => 'Package Prepared',
                'expected_time_interval' => null,
                'expected_time_unit' => null,
                'visible_to_user' => true,
                'sort_order' => 7
            ],
            [
                'status_code' => Order::DISPATCHED,
                'status_name' => 'Dispatched to Carrier',
                'expected_time_interval' => null,
                'expected_time_unit' => null,
                'visible_to_user' => true,
                'sort_order' => 8
            ],
            [
                'status_code' => Order::DELIVERED,
                'status_name' => 'Delivery Completed',
                'expected_time_interval' => null,
                'expected_time_unit' => null,
                'visible_to_user' => true,
                'sort_order' => 9
            ],
            [
                'status_code' => Order::CANCELLED,
                'status_name' => 'Order Cancelled',
                'expected_time_interval' => null,
                'expected_time_unit' => null,
                'visible_to_user' => true,
                'sort_order' => 100
            ],
            [
                'status_code' => Order::RETURNED,
                'status_name' => 'Return to From Delivery',
                'expected_time_interval' => null,
                'expected_time_unit' => null,
                'visible_to_user' => false,
                'sort_order' => 110
            ],

        ];

        foreach ($statusRules as $rule) {
            OrderStatusRule::updateOrCreate(
                ['status_code' => $rule['status_code']],
                $rule
            );
        }
    }
}
