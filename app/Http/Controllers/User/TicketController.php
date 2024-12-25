<?php

namespace App\Http\Controllers\User;

use App\Events\TicketCreated;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function create(Request $request)
    {
        $ticket = Ticket::create([
            'subject' => $request->subject,
            'ticketable_id' => user()->id,
            'ticketable_type' => 'App\Models\User',
            'assigned_admin' => null
        ]);

        broadcast(new TicketCreated($ticket))->toOthers();

        return response()->json($ticket);
    }
}