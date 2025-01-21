@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Promotional Destinations</h2>
        <a href="{{ route('promotional-destinations.create') }}" class="btn btn-primary">
            Add New Destination
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    
                    <th>Destination</th>
                    <th>Generated URL</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>    
                
                @forelse($promotionalDestinations as $promotionalDestination)
                <tr>
                    
                    <td>{{ $promotionalDestination->destination->country }}</td>
                    <td>
                        <a href="{{ $promotionalDestination->generated_url }}" target="_blank" class="text-primary">
                            {{ $promotionalDestination->generated_url }}
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('promotional-destinations.destroy', $promotionalDestination->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No Promotional Destinations Found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
