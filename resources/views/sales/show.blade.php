@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Sale Details</h1>
        <div>
            <a href="{{ route('events.tickets.sales.index', [$event, $ticket]) }}" class="btn btn-primary">Back to Sales</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <p><strong>Ticket Type:</strong> {{ $ticket->type }}</p>
            <p><strong>Event:</strong> {{ $event->name }}</p>
            <p><strong>Customer Name:</strong> {{ $sale->customer_name }}</p>
            <p><strong>Customer Email:</strong> {{ $sale->customer_email }}</p>
            <p><strong>Quantity:</strong> {{ $sale->quantity }}</p>
            <p><strong>Unit Price:</strong> ${{ number_format($ticket->price, 2) }}</p>
            <p><strong>Total Amount:</strong> ${{ number_format($sale->total_amount, 2) }}</p>
            <p><strong>Purchase Date:</strong> {{ $sale->purchase_date->format('M d, Y H:i') }}</p>
        </div>
    </div>

    <form action="{{ route('events.tickets.sales.destroy', [$event, $ticket, $sale]) }}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this sale?')">Delete Sale</button>
    </form>
@endsection