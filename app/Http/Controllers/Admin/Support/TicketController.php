<?php

namespace App\Http\Controllers\Admin\Support;

use App\Http\Controllers\Controller;
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
}
