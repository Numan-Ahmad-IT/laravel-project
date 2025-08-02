@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $event->name }}</h1>
        <div>
            <a href="{{ route('events.edit', $event) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('events.tickets.index', $event) }}" class="btn btn-secondary">View Tickets</a>
            <a href="{{ route('events.index') }}" class="btn btn-primary">Back to Events</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Description:</strong> {{ $event->description }}</p>
            <p><strong>Location:</strong> {{ $event->location }}</p>
            <p><strong>Start Date:</strong> {{ $event->start_date->format('M d, Y H:i') }}</p>
            <p><strong>End Date:</strong> {{ $event->end_date->format('M d, Y H:i') }}</p>
        </div>
    </div>

    <h3>Tickets Summary</h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Available</th>
                    <th>Sold</th>
                    <th>Revenue</th>
                </tr>
            </thead>
            <tbody>
                @foreach($event->tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->type }}</td>
                        <td>${{ number_format($ticket->price, 2) }}</td>
                        <td>{{ $ticket->quantity_available }}</td>
                        <td>{{ $ticket->sales->sum('quantity') }}</td>
                        <td>${{ number_format($ticket->sales->sum('total_amount'), 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection