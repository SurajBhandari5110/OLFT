@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Add New Promotional Destination</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('promotional-destinations.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="destination_id" class="form-label">Select Destination</label>
            <select name="destination_id" id="destination_id" class="form-select" required>
                <option value="">-- Select Destination --</option>
                @foreach ($destinations as $destination)
                    <option value="{{ $destination->id }}">{{ $destination->country }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="dynamic-url" class="form-label">Custom URL (Path Only)</label>
            <input 
                type="text" 
                name="dynamic-url" 
                id="dynamic-url" 
                class="form-control" 
                placeholder="Enter custom URL path (e.g., destination-123)" 
                required
            />
            <div class="form-text">
                Your full URL will look like: <b>http://IP/[your-custom-path]</b>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Generate URL</button>
        <a href="{{ route('promotional-destinations.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
