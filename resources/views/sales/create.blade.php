@extends('layouts.app')

@section('content')
    <h1>Record Sale for {{ $ticket->type }} Ticket ({{ $event->name }})</h1>
    
    <form action="{{ route('events.tickets.sales.store', [$event, $ticket]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>
        <div class="mb-3">
            <label for="customer_email" class="form-label">Customer Email</label>
            <input type="email" class="form-control" id="customer_email" name="customer_email" required>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity (Max: {{ $ticket->quantity_available }})</label>
            <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="{{ $ticket->quantity_available }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Record Sale</button>
        <a href="{{ route('events.tickets.sales.index', [$event, $ticket]) }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection