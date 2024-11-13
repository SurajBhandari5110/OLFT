@extends('voyager::master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <h1>Create Gallery for Package: {{ $package->title }}</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="pk_Package_id" value="{{ $package->pk_Package_id }}">

                <div class="form-group">
                    <label for="images">Select Image:</label>
                    <input type="file" name="images[]" class="form-control" multiple required>
                </div>

                <button type="submit" class="btn btn-primary">Upload Images</button>
            </form>
        </div>
    </div>
@endsection
