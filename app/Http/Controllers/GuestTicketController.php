<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\TempUser;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class GuestTicketController extends Controller
{

    public function create(Request $request)
    {
        $ticketId = null;
        DB::transaction(function () use ($request, &$ticketId) {
            $guest = TempUser::where('phone', $request->phone)->first();
            if (!$guest) {
                $guest = TempUser::create([
                    'name' => $request->name,
                    'phone' => $request->phone
                ]);
            } else {
                $guest->update(['name' => $request->name]);
            }
            $ticket = Ticket::create([
                'subject' => $request->subject,
                'ticketable_id' => $guest->id,
                'ticketable_type' => 'App\Models\TempUser',
                'assigned_admin' => null
            ]);

            // $message = Message::create([
            //     'message' => $request->subject,
            //     'ticket_id' => $ticket->id,
            //     'sender_id' => $guest->id,
            //     'sender_type' => 'App\Models\TempUser'
            // ]);
            // $message = Message::create([
            //     'message' => 'Hi, ' . $guest->name . ' your ticket has been created successfully. Our representative will contact you soon.',
            //     'ticket_id' => $ticket->id,
            //     'sender_id' => NULL,
            //     'sender_type' => NULL
            // ]);

            // $ticket->load('messages');
            $ticketId = $ticket->id;
        });
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
                // 'chatMessages' => $chatMessages,
                // 'ticket_id' => $chatMessages[0]->ticket_id,
                // 'sender_id' => $chatMessages[0]->sender_id,
                'ticket_id' => encrypt($ticketId),
                'message' => 'Ticket created successfully'
            ]);
        }


        // broadcast(new TicketCreated($ticket))->toOthers();


    }


    public function messages($authTicketId, $guestTicketId)
    {
        if (Auth::guard('web')->check() && $authTicketId != 'null') {
            return redirect()->route('u.ticket.messages', encrypt($authTicketId));
        } elseif ($guestTicketId != 'null') {
            $ticket = Ticket::with('messages.sender')->where('id', decrypt($guestTicketId))->first();
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
        return response()->json([
            'success' => false
        ]);
    }
}
