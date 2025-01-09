<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\Support\MessageSendRequest;
use App\Http\Requests\Support\TicketCreateRequest;
use App\Models\Message;
use App\Models\TempUser;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class TicketController extends Controller
{

    public function create(TicketCreateRequest $request)
    {
        try {
            DB::transaction(function () use ($request, &$ticketId) {
                $user = null;
                if (auth()->guard('web')->check()) {
                    $user = auth()->guard('web')->user();
                } else {
                    $user = TempUser::where('phone', $request->phone)->first();
                    if ($user == null) {
                        $user = TempUser::create([
                            'name' => $request->name,
                            'phone' => $request->phone
                        ]);
                    } else {
                        $user->update(['name' => $request->name]);
                    }
                }
                $ticket = Ticket::create([
                    'subject' => $request->subject,
                    'ticketable_id' => $user->id,
                    'ticketable_type' => get_class($user),
                    'assigned_admin' => null
                ]);
                session()->put('ticket_id', encrypt($ticket->id));
                session()->put('last_active_time', now()->timestamp);
            });
            return response()->json([
                'success' => true,
                'message' => 'Ticket created successfully'
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            // \Log::error('Error creating ticket: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage() // Optional: Remove this in production
            ]);
        }
    }



    public function messages()
    {

        try {
            $lastActiveTime = session()->get('last_active_time');
            $ticketId = getTicketId();
            $currentTime = now()->timestamp;
            if ($lastActiveTime && $currentTime - $lastActiveTime > 3600) {
                ticketClosed();
                return response()->json([
                    'success' => false,
                    'message' => 'The session has expired. Your support ticket has been closed.',
                ]);
            }

            $ticket = Ticket::with('messages.sender')->where('id', $ticketId)->first();
            if ($ticket) {
                $ticket->messages->each(function ($message) {
                    $message->load('sender');
                    $message->load('ticket');
                    $message->author_image = $message->sender && $message->sender->image
                        ? asset('storage/' . $message->sender->image)
                        : asset('default_img/male.png');
                    $message->send_at = $message->created_at->diffForHumans();
                });
                return response()->json([
                    'success' => true,
                    'ticket' => $ticket,
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the ticket.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function message_send(MessageSendRequest $request)
    {
        try {
            $lastActiveTime = session()->get('last_active_time', now()->timestamp);
            $ticketId = decrypt(session()->get('ticket_id'));
            $currentTime = now()->timestamp;
            if ($lastActiveTime && $currentTime - $lastActiveTime > 3600) {
                ticketClosed();
                return response()->json([
                    'success' => false,
                    'message' => 'The session has expired. Your ticket has been closed.',
                ], 401);
            }

            $ticket = Ticket::where('id', $ticketId)->first();
            if ($ticket) {
                $message = Message::create([
                    'message' => $request->message,
                    'ticket_id' => $ticket->id,
                    'sender_id' => $ticket->ticketable_id,
                    'sender_type' => $ticket->ticketable_type,
                ]);
                $message->load('sender');
                $message->load('ticket');
                $message->author_image = $message->sender && $message->sender->image
                    ? asset('storage/' . $message->sender->image)
                    : asset('default_img/male.png');
                $message->send_at = $message->created_at->diffForHumans();

                broadcast(new MessageSent($message));
                return response()->json([
                    'success' => true,
                    // 'reply' => $message,
                    'message' => 'Message sent successfully',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending the message.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}