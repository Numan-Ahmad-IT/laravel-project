@extends('layouts.app')

@section('content')
    <h1>Edit {{ $ticket->type }} Ticket for {{ $event->name }}</h1>
    
    <form action="{{ route('events.tickets.update', [$event, $ticket]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="type" class="form-label">Ticket Type</label>
            <input type="text" class="form-control" id="type" name="type" value="{{ $ticket->type }}" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $ticket->price }}" required>
        </div>
        <div class="mb-3">
            <label for="quantity_available" class="form-label">Quantity Available</label>
            <input type="number" class="form-control" id="quantity_available" name="quantity_available" value="{{ $ticket->quantity_available }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('events.tickets.index', $event) }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection