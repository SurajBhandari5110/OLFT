@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Blog List</h1>
    <a href="{{ route('blogs.create') }}" class="btn btn-primary mb-3">Create New Blog</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>By User</th>
                <th>Primary Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($blogs as $blog)
                <tr>
                    <td>{{ $blog->id }}</td>
                    <td>{{ $blog->title }}</td>
                    <td>{{ $blog->by_user }}</td>
                    <td>
                        @if ($blog->primary_image)
                            <img src="{{ $blog->primary_image }}" alt="Primary Image" width="100">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
