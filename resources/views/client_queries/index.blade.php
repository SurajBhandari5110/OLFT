@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Client Queries</h1>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('client-queries.create') }}" class="btn btn-primary">Submit New Query</a>
    </div>

    @if ($queries->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($queries as $query)
                        <tr>
                            <td>{{ $query->id }}</td>
                            <td>{{ $query->fullname }}</td>
                            <td>{{ $query->email }}</td>
                            <td>{{ $query->phone }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($query->message, 50) }}</td>
                            <td>
                                <a href="{{ route('client-queries.show', $query->id) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-warning">
            No client queries found.
        </div>
    @endif
</div>
@endsection
