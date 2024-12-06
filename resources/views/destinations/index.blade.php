@extends('voyager::master')

@section('content')
<div class="container mt-4">
    <h1>Destinations</h1>

    <div class="mb-3">
        <a href="{{ route('destinations.create') }}" class="btn btn-primary">Create New Destination</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Country</th>
                <th>Image</th>
                <th>About</th>
                <th>Attraction</th>
                <th>Coordinates</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($destinations as $destination)
                <tr>
                    <td>{{ $destination->id }}</td>
                    <td>{{ $destination->country }}</td>
                    <td>
                    @if ($destination->image)
                    <img src="{{ $destination->image }}" alt="{{ $destination->country }}" width="100">
                    @endif
                    </td>
                    <td>{{ Str::limit($destination->about, 50) }}</td>
                    <td>{{ Str::limit($destination->attraction, 50) }}</td>
                    <td>{{ $destination->coordinates }}</td>
                    <td>
                        <a href="{{ route('destinations.edit', $destination->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('destinations.destroy', $destination->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this destination?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No destinations available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
