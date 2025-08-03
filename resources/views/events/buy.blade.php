@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h1>Buy Tickets for {{ $event->name }}</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($event->tickets->count() > 0)
                <form action="{{ route('events.purchase', $event->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="ticket_id" class="form-label">Select Ticket Type</label>
                        <select class="form-select" id="ticket_id" name="ticket_id" required>
                            <option value="">-- Select Ticket --</option>
                            @foreach($event->tickets as $ticket)
                                <option value="{{ $ticket->id }}" data-price="{{ $ticket->price }}">
                                    {{ $ticket->type }} - ${{ number_format($ticket->price, 2) }} ({{ $ticket->quantity_available }} available)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Your Email</label>
                        <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                    </div>
                    
                    <div class="mb-3">
                        <h5>Total Price: $<span id="total-price">0.00</span></h5>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Complete Purchase</button>
                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-secondary">Cancel</a>
                </form>
            @else
                <div class="alert alert-warning">
                    No tickets available for this event.
                </div>
                <a href="{{ route('events.show', $event->id) }}" class="btn btn-secondary">Back to Event</a>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ticketSelect = document.getElementById('ticket_id');
            const quantityInput = document.getElementById('quantity');
            const totalPriceSpan = document.getElementById('total-price');
            
            function calculateTotal() {
                const selectedOption = ticketSelect.options[ticketSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    const price = parseFloat(selectedOption.getAttribute('data-price'));
                    const quantity = parseInt(quantityInput.value);
                    const total = price * quantity;
                    totalPriceSpan.textContent = total.toFixed(2);
                } else {
                    totalPriceSpan.textContent = '0.00';
                }
            }
            
            ticketSelect.addEventListener('change', calculateTotal);
            quantityInput.addEventListener('input', calculateTotal);
            
            // Initialize calculation
            calculateTotal();
        });
    </script>
@endpush