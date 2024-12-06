@extends('voyager::master')

@section('content')
<div class="container">
    <h1>Create New Destination</h1>
    <form action="{{ route('voyager.destinations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
        <label for="country">Country</label>
    <select name="country" id="country" class="form-control" required>
    <option value="" disabled selected>Select a Country</option>
    @foreach($countries as $country)
        <option value="{{ $country->name }}">{{ $country->name }}</option>
    @endforeach
    </select>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <div class="form-group">
            <label for="about">About</label>
            <textarea name="about" id="about" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="attraction">Attraction</label>
            <textarea name="attraction" id="attraction" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="coordinates">Coordinates</label>
            <input type="text" name="coordinates" id="coordinates" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection
