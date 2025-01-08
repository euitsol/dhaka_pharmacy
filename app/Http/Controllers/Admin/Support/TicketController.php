<?php

namespace App\Http\Controllers\Admin\Support;

use App\Http\Controllers\Controller;
use App\Http\Requests\Support\MessageSendRequest;
use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class TicketController extends Controller
{
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['tickets'] = Ticket::with('messages.sender')
            ->withCount([
                'messages as active_message_count' => function ($query) {
                    $query->where('is_read', 0)
                        ->where(function ($q) {
                            $q->where('sender_id', '!=', admin()->id)
                                ->orWhere('sender_type', '!=', get_class(admin()));
                        });
                }
            ])
            ->orderBy('status', 'asc')->latest()->get();
        return view('admin.support.ticket.index', $data);
    }

    public function chat($ticket_id): View
    {
        $data['ticket'] = Ticket::with('messages.sender')->findOrFail(decrypt($ticket_id));
        return view('admin.support.ticket.chat', $data);
    }

    public function message_send(MessageSendRequest $request, $ticket_id)
    {
        try {
            $ticket = Ticket::where('id', decrypt($ticket_id))->first();
            if ($ticket) {
                $message = Message::create([
                    'message' => $request->message,
                    'ticket_id' => $ticket->id,
                    'sender_id' => admin()->id,
                    'sender_type' => get_class(admin()),
                ]);
                $message->load('sender');
                $message->load('ticket');
                $message->author_image = $message->sender && $message->sender->image
                    ? asset('storage/' . $message->sender->image)
                    : asset('default_img/male.png');
                $message->send_at = $message->created_at->diffForHumans();
                return response()->json([
                    'success' => true,
                    'reply' => $message,
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