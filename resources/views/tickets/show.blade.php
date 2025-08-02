@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $ticket->type }} Ticket for {{ $event->name }}</h1>
        <div>
            <a href="{{ route('events.tickets.edit', [$event, $ticket]) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('events.tickets.sales.index', [$event, $ticket]) }}" class="btn btn-secondary">View Sales</a>
            <a href="{{ route('events.tickets.index', $event) }}" class="btn btn-primary">Back to Tickets</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Type:</strong> {{ $ticket->type }}</p>
            <p><strong>Price:</strong> ${{ number_format($ticket->price, 2) }}</p>
            <p><strong>Available:</strong> {{ $ticket->quantity_available }}</p>
            <p><strong>Sold:</strong> {{ $ticket->sales->sum('quantity') }}</p>
            <p><strong>Revenue:</strong> ${{ number_format($ticket->sales->sum('total_amount'), 2) }}</p>
        </div>
    </div>

    <h3>Recent Sales</h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ticket->sales->take(5) as $sale)
                    <tr>
                        <td>{{ $sale->customer_name }}</td>
                        <td>{{ $sale->customer_email }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>${{ number_format($sale->total_amount, 2) }}</td>
                        <td>{{ $sale->purchase_date->format('M d, Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection