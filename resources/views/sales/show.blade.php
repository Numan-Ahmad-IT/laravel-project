@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-6">
            <h1>Sale Details</h1>
        </div>
        <div class="col-6 text-end">
            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Back to Sales</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Customer Information</h5>
                    <p><strong>Name:</strong> {{ $sale->customer_name }}</p>
                    <p><strong>Email:</strong> {{ $sale->customer_email }}</p>
                    <p><strong>Date:</strong> {{ $sale->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Ticket Information</h5>
                    <p><strong>Event:</strong> {{ $sale->ticket->event->name }}</p>
                    <p><strong>Ticket Type:</strong> {{ $sale->ticket->type }}</p>
                    <p><strong>Quantity:</strong> {{ $sale->quantity }}</p>
                    <p><strong>Price per Ticket:</strong> ${{ number_format($sale->ticket->price, 2) }}</p>
                    <p><strong>Total Price:</strong> ${{ number_format($sale->total_price, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection