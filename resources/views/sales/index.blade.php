@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Sales for {{ $ticket->type }} Ticket ({{ $event->name }})</h1>
        <div>
            <a href="{{ route('events.tickets.sales.create', [$event, $ticket]) }}" class="btn btn-primary">Record Sale</a>
            <a href="{{ route('events.tickets.show', [$event, $ticket]) }}" class="btn btn-secondary">Back to Ticket</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td>{{ $sale->customer_name }}</td>
                        <td>{{ $sale->customer_email }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>${{ number_format($sale->total_amount, 2) }}</td>
                        <td>{{ $sale->purchase_date->format('M d, Y H:i') }}</td>
                        <td>
                            <a href="{{ route('events.tickets.sales.show', [$event, $ticket, $sale]) }}" class="btn btn-sm btn-info">View</a>
                            <form action="{{ route('events.tickets.sales.destroy', [$event, $ticket, $sale]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $sales->links() }}
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Sales Summary</h5>
            <p><strong>Total Sold:</strong> {{ $ticket->sales->sum('quantity') }}</p>
            <p><strong>Total Revenue:</strong> ${{ number_format($ticket->sales->sum('total_amount'), 2) }}</p>
            <p><strong>Available:</strong> {{ $ticket->quantity_available }}</p>
        </div>
    </div>
@endsection