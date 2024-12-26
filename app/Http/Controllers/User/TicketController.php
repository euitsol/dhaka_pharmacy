<?php

namespace App\Http\Controllers\User;

use App\Events\TicketCreated;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function create(Request $request)
    {
        $ticketId = null;
        DB::transaction(function () use ($request, &$ticketId) {
            $ticket = Ticket::create([
                'subject' => $request->subject,
                'ticketable_id' => user()->id,
                'ticketable_type' => 'App\Models\User',
                'assigned_admin' => null
            ]);

            // $message = Message::create([
            //     'message' => $request->subject,
            //     'ticket_id' => $ticket->id,
            //     'sender_id' => user()->id,
            //     'sender_type' => 'App\Models\User'
            // ]);
            // $message = Message::create([
            //     'message' => 'Hi, ' . user()->name . ' your ticket has been created successfully. Our representative will contact you soon.',
            //     'ticket_id' => $ticket->id,
            //     'sender_id' => NULL,
            //     'sender_type' => NULL
            // ]);

            // $ticket->load('messages');
            $ticketId = $ticket->id;
        });

        // broadcast(new TicketCreated($ticket))->toOthers();

        if ($ticketId == null) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again'
            ]);
        } else {
            // $chatMessages->each(function ($message) {
            //     $message->load('sender');
            //     $message->author_image = $message->sender && $message->sender->image ? asset('storage/' . $message->sender->image) : asset('default_img/male.png');
            //     $message->send_at = $message->created_at->diffForHumans();
            // });

            return response()->json([
                'success' => true,
                // 'chatMessage' => $chatMessages,
                // 'ticket_id' => $chatMessages[0]->ticket_id,
                // 'sender_id' => $chatMessages[0]->sender_id,
                'ticket_id' => encrypt($ticketId),
                'message' => 'Ticket created successfully'
            ]);
        }
    }

    public function messages($ticketId)
    {
        $ticket = Ticket::with('messages.sender')->where('id', decrypt($ticketId))->first();
        if ($ticket) {
            $ticket->messages->each(function ($message) {
                $message->load('sender');
                $message->author_image = $message->sender && $message->sender->image ? asset('storage/' . $message->sender->image) : asset('default_img/male.png');
                $message->send_at = $message->created_at->diffForHumans();
            });


            return response()->json([
                'success' => true,
                'ticket' => $ticket,
                'ticketAbleId' => $ticket->ticketable_id,
            ]);
        }
    }
}
