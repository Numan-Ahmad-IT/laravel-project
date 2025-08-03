<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the events with search functionality.
     */
    public function index(Request $request)
    {
        $query = Event::query()->withCount('tickets');
        
        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('location', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by date range if provided
        if ($request->has('date_filter')) {
            switch ($request->date_filter) {
                case 'upcoming':
                    $query->where('start_date', '>=', now());
                    break;
                case 'past':
                    $query->where('end_date', '<', now());
                    break;
                case 'this_week':
                    $query->whereBetween('start_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereBetween('start_date', [now()->startOfMonth(), now()->endOfMonth()]);
                    break;
            }
        }

        // Order by start date by default
        $query->orderBy('start_date');

        $events = $query->paginate(10)->withQueryString();
        
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $event = new Event($validated);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('event-images', 'public');
            $event->image = $path;
        }

        $event->save();

        return redirect()->route('events.index')
                         ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        // Load tickets with their sales count
        $event->load(['tickets' => function($query) {
            $query->withCount('sales');
        }]);

        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $event->fill($validated);

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            
            $path = $request->file('image')->store('event-images', 'public');
            $event->image = $path;
        }

        $event->save();

        return redirect()->route('events.index')
                         ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        // Delete associated image if exists
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        
        $event->delete();
        
        return redirect()->route('events.index')
                         ->with('success', 'Event deleted successfully.');
    }

    /**
     * Show the ticket purchase form for the event.
     */
    public function buy(Event $event)
    {
        // Only show tickets that are still available
        $event->load(['tickets' => function($query) {
            $query->where('quantity_available', '>', 0);
        }]);

        if ($event->tickets->isEmpty()) {
            return redirect()->route('events.show', $event->id)
                             ->with('error', 'No tickets available for this event.');
        }

        return view('events.buy', compact('event'));
    }

    /**
     * Process the ticket purchase for the event.
     */
    public function purchase(Request $request, Event $event)
    {
        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,id,event_id,' . $event->id,
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $ticket = Ticket::findOrFail($validated['ticket_id']);

        // Check ticket availability
        if ($ticket->quantity_available < $validated['quantity']) {
            return back()->withInput()
                         ->with('error', 'Not enough tickets available. Only ' . $ticket->quantity_available . ' left.');
        }

        // Create the sale
        $sale = Sale::create([
            'ticket_id' => $ticket->id,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'quantity' => $validated['quantity'],
            'total_price' => $ticket->price * $validated['quantity'],
            'status' => 'completed',
        ]);

        // Update ticket availability
        $ticket->decrement('quantity_available', $validated['quantity']);

        return redirect()->route('events.show', $event->id)
                         ->with('success', 'Your tickets have been purchased successfully! A confirmation has been sent to your email.');
    }

    /**
     * Export event attendees list.
     */
    public function exportAttendees(Event $event)
    {
        // This would typically generate a CSV or Excel file
        // Implementation depends on your preferred export package
        // (e.g., Laravel Excel, League CSV, etc.)
    }
}