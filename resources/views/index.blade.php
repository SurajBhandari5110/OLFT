<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Tours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #343a40;
        }
        .card-img-overlay-custom {
            display: flex;
            justify-content: center;
            align-items: flex-end;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">My Travel Agency</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Destination</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tour</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Blogs</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Upcoming Tours</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($packages as $package)
            <div class="col">
                <div class="card h-100 border">
                    <img src="{{ asset($package->image) }}" class="card-img-top" style="height:300px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $package->title }}</h5>
                        <a href="{{ route('package.show', $package->pk_Package_id) }}" class="btn btn-primary">View Details</a>


                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @yield('content')
    




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
