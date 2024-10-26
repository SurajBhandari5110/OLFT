@extends('tourguides.layout')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Guides</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            height: 300px;
            object-fit: cover;
        }
        .card-body {
            text-align: center;
        }
        .card-footer {
            text-align: center;
            background-color: #f8f9fa;
        }
        .insta-link {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Tour Guides</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($tourguides as $tourguide)
            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset($tourguide->image) }}" alt="{{ $tourguide->captain }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $tourguide->captain }}</h5>
                        <p class="card-text">Phone: {{ $tourguide->phn_number }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ $tourguide->insta }}" class="insta-link" target="_blank">Instagram Profile</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
