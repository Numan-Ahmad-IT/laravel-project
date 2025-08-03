@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-6">
            <h1>Ticket Details</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Back to Tickets</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Ticket Information</h5>
                    <p><strong>Type:</strong> {{ $ticket->type }}</p>
                    <p><strong>Price:</strong> ${{ number_format($ticket->price, 2) }}</p>
                    <p><strong>Available:</strong> {{ $ticket->quantity_available }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Event Information</h5>
                    <p><strong>Event:</strong> {{ $ticket->event->name }}</p>
                    <p><strong>Location:</strong> {{ $ticket->event->location }}</p>
                    <p><strong>Date:</strong> {{ $ticket->event->start_date->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection