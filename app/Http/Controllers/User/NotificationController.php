<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function read_all(Request $request)
    {
        if ($request->has('id')) {
            $notificationId = $request->id;

            $notification = user()->unreadNotifications()->find($notificationId);

            if ($notification) {
                $notification->markAsRead();
                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false, 'message' => 'Notification not found']);
        }
        user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}
