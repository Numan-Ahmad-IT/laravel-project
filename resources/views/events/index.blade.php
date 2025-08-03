@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-6">
            <h1>Events</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('events.create') }}" class="btn btn-primary">Create Event</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
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
                            <td>{{ $event->id }}</td>
                            <td>{{ $event->name }}</td>
                            <td>{{ $event->location }}</td>
                            <td>{{ $event->start_date->format('M d, Y H:i') }}</td>
                            <td>{{ $event->end_date->format('M d, Y H:i') }}</td>
                            <td>
                                <a href="{{ route('events.show', $event->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $events->links() }}
        </div>
    </div>
@endsection