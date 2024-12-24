<?php

use App\Models\Admin;
use App\Models\Order;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('order-status-changed.{id}', function ($user, $id) {
    return  $user->id === (int) $id;
}, ['guards' => ['admin']]);

Broadcast::channel('user-notification.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
}, ['guards' => ['web']]);

Broadcast::channel('ticket.{ticket_id}', function ($ticket, $ticketId) {
    return true; // Adjust logic for authorization if needed
});