@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3>Query Details</h3>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <p class="mb-1"><strong>Full Name:</strong></p>
                <p class="form-control bg-light">{{ $query->fullname }}</p>
            </div>
            <div class="mb-3">
                <p class="mb-1"><strong>Email:</strong></p>
                <p class="form-control bg-light">{{ $query->email }}</p>
            </div>
            <div class="mb-3">
                <p class="mb-1"><strong>Phone:</strong></p>
                <p class="form-control bg-light">{{ $query->phone }}</p>
            </div>
            <div class="mb-3">
                <p class="mb-1"><strong>Message:</strong></p>
                <textarea class="form-control bg-light" rows="5" readonly>{{ $query->message }}</textarea>
            </div>
        </div>
        
    </div>
</div>
@endsection
