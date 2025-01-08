@extends('layouts.app')

@section('content')
<h1>Promotional Packages</h1>
<a href="{{ route('promotional-packages.create') }}" class="btn btn-primary mb-3">Add New Package</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Package ID</th>
            <th>Generated URL</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($promotionalPackages as $package)
        <tr>
            <td>{{ $package->id }}</td>
            <td>{{ $package->pk_Package_id }}</td>
            <td><a href="{{ $package->generated_url }}" target="_blank">{{ $package->generated_url }}</a></td>
            <td>
               
               

                <!-- Remove Button -->
                <form action="{{ route('promotional-packages.destroy', $package->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to remove this package?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
