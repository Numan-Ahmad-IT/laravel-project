<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Ticket;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::query()->with('ticket.event');
        
        if ($request->has('search')) {
            $query->where('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_email', 'like', '%' . $request->search . '%');
        }

        $sales = $query->paginate(10);
        
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $tickets = Ticket::with('event')->get();
        return view('sales.create', compact('tickets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);

        if ($ticket->quantity_available < $request->quantity) {
            return back()->with('error', 'Not enough tickets available. Only ' . $ticket->quantity_available . ' left.');
        }

        $sale = new Sale([
            'ticket_id' => $request->ticket_id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'quantity' => $request->quantity,
            'total_price' => $ticket->price * $request->quantity,
            'status' => 'completed',
        ]);

        $sale->save();

        // Update ticket availability
        $ticket->quantity_available -= $request->quantity;
        $ticket->save();

        return redirect()->route('sales.index')->with('success', 'Ticket sale completed successfully.');
    }

    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        // Return the quantity to the ticket
        $ticket = $sale->ticket;
        $ticket->quantity_available += $sale->quantity;
        $ticket->save();
        
        $sale->delete();
        
        return redirect()->route('sales.index')->with('success', 'Sale record deleted successfully.');
    }
}