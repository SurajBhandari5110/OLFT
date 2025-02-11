@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Blogs</h2>
    <a href="{{ route('blogs.create') }}" class="btn btn-primary mb-3">Create New Blog</a>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Slug</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blogs as $blog)
                <tr>
                    <td>{{ $blog->title }}</td>
                    <td>{{ $blog->slug }}</td>
                    <td>
                        <form action="{{ route('blogs.destroy', $blog->blog_id) }}" method="POST" style="display: inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
@endsection
