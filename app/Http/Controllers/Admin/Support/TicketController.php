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
        $data['tickets'] = Ticket::with('messages.sender')->orderBy('status', 'asc')->latest()->get();
        return view('admin.support.ticket.index', $data);
    }
}