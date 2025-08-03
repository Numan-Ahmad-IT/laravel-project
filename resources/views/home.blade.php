@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h1>Upcoming Events</h1>
        </div>
    </div>

    <div class="row">
        @foreach($events as $event)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white text-center p-5" style="height: 200px;">
                            <i class="bi bi-calendar-event" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->name }}</h5>
                        <p class="card-text text-muted">
                            <i class="bi bi-geo-alt"></i> {{ $event->location }}<br>
                            <i class="bi bi-calendar"></i> {{ $event->start_date->format('M d, Y H:i') }}
                        </p>
                        <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary">View Details</a>
                        <a href="{{ route('events.buy', $event->id) }}" class="btn btn-success">Buy Tickets</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-12">
            {{ $events->links() }}
        </div>
    </div>
@endsection