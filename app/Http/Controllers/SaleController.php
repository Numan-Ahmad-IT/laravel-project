<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Event $event, Ticket $ticket)
    {
        $sales = $ticket->sales()->paginate(10);
        return view('sales.index', compact('event', 'ticket', 'sales'));
    }

    public function create(Event $event, Ticket $ticket)
    {
        return view('sales.create', compact('event', 'ticket'));
    }

    public function store(Request $request, Event $event, Ticket $ticket)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'quantity' => 'required|integer|min:1|max:' . $ticket->quantity_available,
        ]);

        $totalAmount = $ticket->price * $request->quantity;

        $sale = new Sale([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'quantity' => $request->quantity,
            'total_amount' => $totalAmount,
            'purchase_date' => now(),
        ]);

        $ticket->sales()->save($sale);
        $ticket->decrement('quantity_available', $request->quantity);

        return redirect()->route('events.tickets.sales.index', [$event, $ticket])->with('success', 'Sale recorded successfully.');
    }

    public function show(Event $event, Ticket $ticket, Sale $sale)
    {
        return view('sales.show', compact('event', 'ticket', 'sale'));
    }

    public function destroy(Event $event, Ticket $ticket, Sale $sale)
    {
        $sale->delete();
        $ticket->increment('quantity_available', $sale->quantity);
        return redirect()->route('events.tickets.sales.index', [$event, $ticket])->with('success', 'Sale deleted successfully.');
    }
}