<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Package</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Itineraries</h1>
   

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($itineraries->isEmpty())
        <div class="alert alert-info">No itineraries available. Please create a new one.</div>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Package Title</th>
                <th>Day</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($itineraries as $itinerary)
                <tr>
                    <td>{{ $itinerary->id }}</td>
                    <td>{{ $itinerary->pk_Package_id }}</td> <!-- Fetch package title -->
                    <td>Day {{ $itinerary->days }}</td>
                    <td>{{ $itinerary->title }}</td>
                    <td>{{ $itinerary->description }}</td>
                    <td>
                        @if($itinerary->image)
                            <img src="{{ $itinerary->image }}" alt="{{ $itinerary->title }}" class="img-fluid rounded" style="max-height: 120px; object-fit: cover;">
                        @else
                            No image available
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('itineraries.edit', $itinerary->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('itineraries.destroy', $itinerary->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this itinerary?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
</body>
</html>

