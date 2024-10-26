@extends('inclusions.layout')

@section('content')
<div class="container">
    <h1>Inclusions List</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Package Name</th>
                <th>Benefit</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inclusions as $inclusion)
                <tr>
                    <td>{{ $inclusion->package->title ?? 'N/A' }}</td>
                    <td>{{ $inclusion->include->Name ?? 'N/A' }}</td>
                    <td>{{ $inclusion->isActive ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a href="{{ route('inclusions.edit', $inclusion->inclusion_id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('inclusions.destroy', $inclusion->inclusion_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this inclusion?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
