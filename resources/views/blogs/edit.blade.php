@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Edit Blog</h1>
    <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $blog->title }}" required>
        </div>
        <div class="mb-3">
            <label for="by_user" class="form-label">By User</label>
            <input type="text" class="form-control" id="by_user" name="by_user" value="{{ $blog->by_user }}" required>
        </div>
        <div class="mb-3">
            <label for="primary_image" class="form-label">Primary Image</label>
            <input type="file" class="form-control" id="primary_image" name="primary_image">
            <label for="image" style="font-size:12px; color:red;">Image size must be 500KB or less!</label>
            @if ($blog->primary_image)
                <img src="{{ $blog->primary_image }}" alt="Primary Image" width="100" class="mt-2">
            @endif
        </div>
        <div class="mb-3">
            <label for="secondary_image" class="form-label">Secondary Image</label>
            <input type="file" class="form-control" id="secondary_image" name="secondary_image">
            <label for="image" style="font-size:12px; color:red;">Image size must be 500KB or less!</label>
            @if ($blog->secondary_image)
                <img src="{{ $blog->secondary_image }}" alt="Secondary Image" width="100" class="mt-2">
            @endif
        </div>
        <div class="mb-3">
            <label for="moto1" class="form-label">Moto 1</label>
            <input type="text" class="form-control" id="moto1" name="moto1" value="{{ $blog->moto1 }}">
        </div>
        <button type="submit" class="btn btn-success">Update Blog</button>
    </form>
@endsection
