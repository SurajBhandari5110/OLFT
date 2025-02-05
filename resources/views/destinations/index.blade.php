@extends('voyager::master')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Destinations</h1>
        <a href="{{ route('destinations.create') }}" class="btn btn-success btn-lg">
            <i class="fas fa-plus-circle"></i> Create New Destination
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Destination List</h4>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Country</th>
                        <th>Total Packages</th>
                        <th>Image</th>
                        <th>About</th>
                        <th>Attraction</th>
                        <th>Coordinates</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($destinations as $destination)
                        <tr>
                            <td>{{ $destination->id }}</td>
                            <td>{{ $destination->country }}</td>
                            <td> {{ $destination->total_packages }}</td>
                            <td>
                                @if ($destination->image)
                                    <img src="{{ $destination->image }}" alt="{{ $destination->country }}" class="rounded" style="width: 100px; height: auto;">
                                @endif
                            </td>
                            <td>{{ Str::limit($destination->about, 50) }}</td>
                            <td>{{ Str::limit($destination->attraction, 50) }}</td>
                            <td>{{ $destination->coordinates }}</td>
                            <td class="text-center">
                                <a href="{{ route('destinations.edit', $destination->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('destinations.destroy', $destination->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this destination?')">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No destinations available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Include Font Awesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<!-- Include Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
