@extends('voyager::master')

@section('content')
<div class="container">
    <h1>Edit Destination</h1>
    <form action="{{ route('destinations.update', $destination) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="country">Country</label>
            <select name="country" id="country" class="form-control" required>
                @foreach ($countries as $country)
                <option value="{{ $country->name }}" {{ $destination->country == $country->name ? 'selected' : '' }}>
                    {{ $country->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if ($destination->image)
            <img src="{{ $destination->image }}" alt="Current Image" width="100" class="mt-2">
            @endif
        </div>
        <div class="form-group">
            <label for="about">About</label>
            <textarea name="about" id="about" class="form-control">{{ $destination->about }}</textarea>
        </div>
        <div class="form-group">
            <label for="attraction">Attraction</label>
            <textarea name="attraction" id="attraction" class="form-control">{{ $destination->attraction }}</textarea>
        </div>
        <div class="form-group">
            <label for="coordinates">Coordinates</label>
            <input type="text" name="coordinates" id="coordinates" class="form-control" value="{{ $destination->coordinates }}">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
