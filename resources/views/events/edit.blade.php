@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h1>Edit Event</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label">Event Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $event->name }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ $event->description }}</textarea>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ $event->start_date->format('Y-m-d\TH:i') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ $event->end_date->format('Y-m-d\TH:i') }}" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="{{ $event->location }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">Event Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    
                    @if($event->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $event->image) }}" alt="Current image" style="max-height: 150px;">
                            <p class="text-muted mt-1">Current image</p>
                        </div>
                    @endif
                </div>
                
                <button type="submit" class="btn btn-primary">Update Event</button>
                <a href="{{ route('events.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection