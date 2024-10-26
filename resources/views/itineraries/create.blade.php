@extends('voyager::master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <h1>Create Itineraries for Package: {{ $package->title }}</h1>

            <form action="{{ route('save.itinerary') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="package_id" value="{{ $package->pk_Package_id }}">

                @for ($day = 1; $day <= $duration; $day++)
                    <div class="form-group">
                        <label for="day">Day {{ $day }}</label>
                        <input type="hidden" name="itineraries[{{ $day }}][days]" value="{{ $day }}">

                        <div class="row">
                            <div class="col-md-4">
                                <label for="title">Title for Day {{ $day }}:</label>
                                <input type="text" name="itineraries[{{ $day }}][title]" class="form-control" placeholder="Enter title for day {{ $day }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="description">Description for Day {{ $day }}:</label>
                                <textarea name="itineraries[{{ $day }}][description]" class="form-control" placeholder="Enter description for day {{ $day }}" required></textarea>
                            </div>

                            <div class="col-md-4">
                                <label for="image">Image for Day {{ $day }} (Optional):</label>
                                <input type="file" name="itineraries[{{ $day }}][image]" class="form-control">
                            </div>
                        </div>
                    </div>
                @endfor

                <button type="submit" class="btn btn-primary">Save Itineraries</button>
            </form>
        </div>
    </div>
@endsection
