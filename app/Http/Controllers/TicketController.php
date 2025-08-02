<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Event $event)
    {
        $tickets = $event->tickets()->paginate(10);
        return view('tickets.index', compact('event', 'tickets'));
    }

    public function create(Event $event)
    {
        return view('tickets.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity_available' => 'required|integer|min:1',
        ]);

        $event->tickets()->create($request->all());

        return redirect()->route('events.tickets.index', $event)->with('success', 'Ticket created successfully.');
    }

    public function show(Event $event, Ticket $ticket)
    {
        return view('tickets.show', compact('event', 'ticket'));
    }

    public function edit(Event $event, Ticket $ticket)
    {
        return view('tickets.edit', compact('event', 'ticket'));
    }

    public function update(Request $request, Event $event, Ticket $ticket)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity_available' => 'required|integer|min:1',
        ]);

        $ticket->update($request->all());

        return redirect()->route('events.tickets.index', $event)->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Event $event, Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('events.tickets.index', $event)->with('success', 'Ticket deleted successfully.');
    }
}