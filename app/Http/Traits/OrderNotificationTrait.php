<?php

namespace App\Http\Traits;

use App\Models\Admin;
use App\Models\NotificationTemplate;
use App\Models\User;
use App\Notifications\Frontend\OrderNotification;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;

trait OrderNotificationTrait{

    public function order_notification($order, $key)
    {
        $template = NotificationTemplate::where('key', $key)->first();
        if(!empty($template) && !empty($template->message)){
            Log::alert($template);
            $placeholders = [
                '{order-id}' => $order->order_id,
            ];
            $message = str_replace(array_keys($placeholders), array_values($placeholders), $template->message);

            //test
            $admin = Admin::findOrFail(1);
            $admin->notify( new OrderNotification($message, $admin));
        }
    }
}
