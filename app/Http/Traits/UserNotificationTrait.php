<?php

namespace App\Http\Traits;

use App\Models\Admin;
use App\Models\NotificationTemplate;
use App\Notifications\Frontend\UserNotification;
use Illuminate\Support\Facades\Log;

trait UserNotificationTrait
{

    public function order_notification($order, $key)
    {
        $status = null;
        switch ($order->status) {
            case 1:
                $status = 'Submitted';
                break;
            case 2:
                $status = 'Proccesing';
                break;
            case 4:
                $status = 'Shipped';
                break;
            case 5:
                $status = 'Out For Delivery';
                break;
            case 6:
                $status = 'Delivered';
                break;
            default:
                $status = null;
        }
        if ($status != null) {
            $template = NotificationTemplate::where('key', $key)->first();
            if (!empty($template) && !empty($template->message)) {
                $placeholders = [
                    '{order-id}' => $order->order_id,
                    '{order-status}' => strtolower($status),
                ];
                $data['message'] = str_replace(array_keys($placeholders), array_values($placeholders), $template->message);
                $data['url'] = route('u.order.details', encrypt($order->id));
                $data['user_id'] = $order->customer->id;
                $data['title'] = str_replace(array_keys($placeholders), array_values($placeholders), $template->name);

                $order->customer->notify(new UserNotification($data));
            }
        }
    }
}
