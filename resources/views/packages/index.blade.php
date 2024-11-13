@extends('packages.layout')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packages</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .package-image {
            max-height: 150px;
            max-width: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Packages</h1>
        <a href="{{ route('packages.create') }}" class="btn btn-success mb-3">Create New Package</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($packages->isEmpty())
            <div class="alert alert-info">No packages available. Please create a new one.</div>
        @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Package ID</th>
                    <th>Title</th>
                    <th>About Place</th>
                    <th>Destination Location</th>
                    <th>Duration</th>
                    <th>Tour Type</th>
                    <th>Image</th>
                    <th>Group Size</th>
                    <th>Tour Guide</th>
                    <th>Coordinates of Destination</th>
                    <th>Travel With Bus</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($packages as $package)
                    <tr>
                        <td>{{ $package->pk_Package_id }}</td>
                        <td>{{ $package->title }}</td>
                        <td>
                            {{ \Illuminate\Support\Str::limit($package->about, 100) }}
                            @if(strlen($package->about) > 100)
                                <a href="#" class="text-primary" onclick="event.preventDefault(); this.nextElementSibling.style.display='inline'; this.style.display='none';">Read More</a>
                                <span style="display: none;">{{ substr($package->about, 100) }}</span>
                            @endif
                        </td>
                        <td>{{ $package->location }}</td>
                        <td>{{ $package->duration }}</td>
                        <td>{{ $package->tour_type }}</td>
                        <td>
                            <img src="{{ asset($package->image) }}" alt="{{ $package->title }}" class="img-fluid rounded package-image">
                        </td>
                        <td>{{ $package->group_size }}</td>
                        <td>{{ $package->tour_guide }}</td>
                        <td>{{ $package->coordinates }}</td>
                        <td>{{ $package->travel_with_bus ? 'Yes' : 'No' }}</td>
                        <td>
                            @if (!$package->hasItineraries)
                                <a href="{{ route('create.itinerary', $package->pk_Package_id) }}" class="btn btn-primary btn-sm">Create Itineraries</a>
                            @else
                                <form action="{{ route('itineraries.destroyByPackage', $package->pk_Package_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete all itineraries for this package?')">Delete All Itineraries</button>
                                </form>
                            @endif

                            <a href="{{ route('packages.edit', $package->pk_Package_id) }}" class="btn btn-warning btn-sm">Edit Package</a>
                            <form action="{{ route('packages.destroy', $package->pk_Package_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this package?')">Delete Package</button>
                            </form>

                            <a href="{{ route('inclusions.create', ['packageId' => $package->pk_Package_id]) }}" class="btn btn-success btn-sm">Manage Inclusions</a>
                            <a href="{{ route('galleries.create', $package->pk_Package_id) }}" class="btn btn-primary btn-sm">Create Gallery</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
@endsection
