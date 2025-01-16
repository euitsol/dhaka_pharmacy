<?php

namespace App\Http\Controllers\User;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;


class MessageController extends Controller
{
    // public function sendMessage(Request $request)
    // {
    //     $message = Message::create([
    //         'message' => $request->message,
    //         'sender_id' => $request->sender_id,
    //         'sender_type' => $request->sender_type,
    //         'ticket_id' => $request->ticket_id,
    //     ]);

    //     broadcast(new MessageSent($message))->toOthers();

    //     return response()->json($message);
    // }
}