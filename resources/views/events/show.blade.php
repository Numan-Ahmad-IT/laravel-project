@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-6">
            <h1>{{ $event->name }}</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
            <a href="{{ route('events.index') }}" class="btn btn-secondary">Back to Events</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" class="img-fluid mb-3" alt="{{ $event->name }}">
                    @endif
                    
                    <p class="text-muted">
                        <i class="bi bi-geo-alt"></i> {{ $event->location }}<br>
                        <i class="bi bi-calendar"></i> {{ $event->start_date->format('M d, Y H:i') }} to {{ $event->end_date->format('M d, Y H:i') }}
                    </p>
                    
                    <p>{{ $event->description }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Event Tickets</h5>
                </div>
                <div class="card-body">
                    @if($event->tickets->count() > 0)
                        <div class="list-group">
                            @foreach($event->tickets as $ticket)
                                <div class="list-group-item">
                                    <h6 class="mb-1">{{ $ticket->type }}</h6>
                                    <p class="mb-1">Price: ${{ number_format($ticket->price, 2) }}</p>
                                    <p class="mb-1">Available: {{ $ticket->quantity_available }}</p>
                                    <a href="{{ route('events.buy', $event->id) }}" class="btn btn-sm btn-success mt-2">Buy Now</a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No tickets available for this event.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection