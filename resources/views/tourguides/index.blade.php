@extends('tourguides.layout')

@section('content')
<div class="container">
    <h1 class="mt-4">Captains</h1>
    <a href="{{ route('tourguides.create') }}" class="btn btn-success mb-3">Add New Guide</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Captain Name</th>
                <th>Image</th>
                <th>Phone Number</th>
                <th>Instagram</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tourguides as $tourguide)
            <tr>
                <td>{{ $tourguide->id }}</td>
                <td>{{ $tourguide->captain }}</td>
                <td><img src="{{ asset($tourguide->image) }}" alt="image" style="width: 100px;"></td>
                <td>{{ $tourguide->phn_number }}</td>
                <td>{{ $tourguide->insta }}</td>
                <td>
                    <a href="{{ route('tourguides.edit', $tourguide->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    
                    <form action="{{ route('tourguides.destroy', $tourguide->id) }}" method="POST" style="display:inline-block;">
                        {!! csrf_field() !!}
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
