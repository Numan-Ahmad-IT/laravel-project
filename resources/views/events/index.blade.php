@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Events</h1>
        <a href="{{ route('events.create') }}" class="btn btn-primary">Create Event</a>
    </div>

    <form action="{{ route('events.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search events..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>{{ $event->name }}</td>
                        <td>{{ $event->location }}</td>
                        <td>{{ $event->start_date->format('M d, Y H:i') }}</td>
                        <td>{{ $event->end_date->format('M d, Y H:i') }}</td>
                        <td>
                            <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            <a href="{{ route('events.tickets.index', $event) }}" class="btn btn-sm btn-secondary">Tickets</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $events->links() }}
    </div>
@endsection