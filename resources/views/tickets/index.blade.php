@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tickets for {{ $event->name }}</h1>
        <div>
            <a href="{{ route('events.tickets.create', $event) }}" class="btn btn-primary">Create Ticket</a>
            <a href="{{ route('events.show', $event) }}" class="btn btn-secondary">Back to Event</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Available</th>
                    <th>Sold</th>
                    <th>Revenue</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->type }}</td>
                        <td>${{ number_format($ticket->price, 2) }}</td>
                        <td>{{ $ticket->quantity_available }}</td>
                        <td>{{ $ticket->sales->sum('quantity') }}</td>
                        <td>${{ number_format($ticket->sales->sum('total_amount'), 2) }}</td>
                        <td>
                            <a href="{{ route('events.tickets.show', [$event, $ticket]) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('events.tickets.edit', [$event, $ticket]) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('events.tickets.destroy', [$event, $ticket]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            <a href="{{ route('events.tickets.sales.index', [$event, $ticket]) }}" class="btn btn-sm btn-secondary">Sales</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $tickets->links() }}
    </div>
@endsection