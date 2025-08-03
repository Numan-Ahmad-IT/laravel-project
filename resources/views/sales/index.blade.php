@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-6">
            <h1>Ticket Sales</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('sales.create') }}" class="btn btn-primary">Create Sale</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Event</th>
                        <th>Ticket Type</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                        <tr>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->customer_name }}<br><small>{{ $sale->customer_email }}</small></td>
                            <td>{{ $sale->ticket->event->name }}</td>
                            <td>{{ $sale->ticket->type }}</td>
                            <td>{{ $sale->quantity }}</td>
                            <td>${{ number_format($sale->total_price, 2) }}</td>
                            <td>{{ $sale->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-info">View</a>
                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $sales->links() }}
        </div>
    </div>
@endsection