@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h1>Edit Ticket</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="event_id" class="form-label">Event</label>
                    <select class="form-select" id="event_id" name="event_id" required>
                        <option value="">-- Select Event --</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ $ticket->event_id == $event->id ? 'selected' : '' }}>{{ $event->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="type" class="form-label">Ticket Type</label>
                    <input type="text" class="form-control" id="type" name="type" value="{{ $ticket->type }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="{{ $ticket->price }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="quantity_available" class="form-label">Quantity Available</label>
                    <input type="number" class="form-control" id="quantity_available" name="quantity_available" min="1" value="{{ $ticket->quantity_available }}" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Ticket</button>
                <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection