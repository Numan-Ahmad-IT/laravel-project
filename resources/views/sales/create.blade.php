@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h1>Create Ticket Sale</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('sales.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="ticket_id" class="form-label">Ticket</label>
                    <select class="form-select" id="ticket_id" name="ticket_id" required>
                        <option value="">-- Select Ticket --</option>
                        @foreach($tickets as $ticket)
                            <option value="{{ $ticket->id }}" data-price="{{ $ticket->price }}" data-available="{{ $ticket->quantity_available }}">
                                {{ $ticket->event->name }} - {{ $ticket->type }} (${{ number_format($ticket->price, 2) }}, {{ $ticket->quantity_available }} available)
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1" required>
                    <small id="available-text" class="text-muted"></small>
                </div>
                
                <div class="mb-3">
                    <label for="customer_name" class="form-label">Customer Name</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                </div>
                
                <div class="mb-3">
                    <label for="customer_email" class="form-label">Customer Email</label>
                    <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                </div>
                
                <div class="mb-3">
                    <h5>Total Price: $<span id="total-price">0.00</span></h5>
                </div>
                
                <button type="submit" class="btn btn-primary">Complete Sale</button>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ticketSelect = document.getElementById('ticket_id');
            const quantityInput = document.getElementById('quantity');
            const totalPriceSpan = document.getElementById('total-price');
            const availableText = document.getElementById('available-text');
            
            function updateInfo() {
                const selectedOption = ticketSelect.options[ticketSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    const price = parseFloat(selectedOption.getAttribute('data-price'));
                    const available = parseInt(selectedOption.getAttribute('data-available'));
                    const quantity = parseInt(quantityInput.value);
                    
                    availableText.textContent = `${available} tickets available`;
                    quantityInput.max = available;
                    
                    if (quantity > available) {
                        quantityInput.value = available;
                    }
                    
                    const total = price * (quantity > available ? available : quantity);
                    totalPriceSpan.textContent = total.toFixed(2);
                } else {
                    availableText.textContent = '';
                    totalPriceSpan.textContent = '0.00';
                }
            }
            
            ticketSelect.addEventListener('change', updateInfo);
            quantityInput.addEventListener('input', updateInfo);
            
            // Initialize
            updateInfo();
        });
    </script>
@endpush