@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Blog</h1>

    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="by_user">By User</label>
            <input type="text" name="by_user" id="by_user" class="form-control" value="{{ old('by_user') }}" required>
        </div>

        <div class="form-group">
            <label for="comment">Comment</label>
            <textarea name="comment" id="comment" class="form-control">{{ old('comment') }}</textarea>
        </div>

        <div class="form-group">
            <label for="primary_image">Primary Image</label>
            <input type="file" name="primary_image" id="primary_image" class="form-control" required>
            <label for="image" style="font-size:12px; color:red;">Image size must be 500KB or less!</label>
        </div>

        <div class="form-group">
            <label for="secondary_image">Secondary Image</label>
            <input type="file" name="secondary_image" id="secondary_image" class="form-control">
            <label for="image" style="font-size:12px; color:red;">Image size must be 500KB or less!</label>
        </div>

        <div class="form-group">
            <label for="moto1">Moto 1</label>
            <input type="text" name="moto1" id="moto1" class="form-control" value="{{ old('moto1') }}">
        </div>

        <div class="form-group">
            <label for="para1">Paragraph 1</label>
            <textarea name="para1" id="para1" class="form-control">{{ old('para1') }}</textarea>
        </div>
        <div class="form-group">
            <label for="para2">Paragraph 1</label>
            <textarea name="para2" id="para2" class="form-control">{{ old('para2') }}</textarea>
        </div>

        <div class="form-group">
            <label for="moto2">Moto 2</label>
            <input type="text" name="moto2" id="moto2" class="form-control" value="{{ old('moto2') }}">
        </div>

        <button type="submit" class="btn btn-primary">Create Blog</button>
    </form>
</div>
@endsection
