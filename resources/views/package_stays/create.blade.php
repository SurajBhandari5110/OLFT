@extends('voyager::master')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Add Stays to Package: {{ $package->title }}</h1>

    <!-- Display Already Added Hotels -->
    <h4>Already Added Hotels</h4>
    @if($existingHotels->isEmpty())
        <p>No hotels have been added to this package yet.</p>
    @else
        <ul class="list-group mb-4">
            @foreach ($existingHotels as $hotel)
                <li class="list-group-item">{{ $hotel->name }} ({{ $hotel->state }}, {{ $hotel->country }})</li>
            @endforeach
        </ul>
    @endif

    <!-- Form to Add New Hotel -->
    <form action="{{ route('package_stays.store', $package->pk_Package_id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="pk_hotel_id">Select Hotel</label>
            <select name="pk_hotel_id" id="pk_hotel_id" class="form-control">
                @foreach($hotels as $hotel)
                    <option value="{{ $hotel->pk_hotel_id }}">{{ $hotel->name }} ({{ $hotel->state }}, {{ $hotel->country }})</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Stay</button>
        <a href="{{ route('packages.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
