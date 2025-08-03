@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-6">
            <h1>Tickets</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('tickets.create') }}" class="btn btn-primary">Create Ticket</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Event</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Available</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->event->name }}</td>
                            <td>{{ $ticket->type }}</td>
                            <td>${{ number_format($ticket->price, 2) }}</td>
                            <td>{{ $ticket->quantity_available }}</td>
                            <td>
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $tickets->links() }}
        </div>
    </div>
@endsection