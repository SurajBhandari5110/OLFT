@extends('voyager::master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <h1>Galleries for Packages</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Package ID</th>
                        <th>Package Title</th>
                        <th>Images</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($packages as $package)
                        <tr>
                            <td>{{ $package->pk_Package_id }}</td>
                            <td>{{ $package->title }}</td>
                            <td>
                                @if ($package->galleries->isEmpty())
                                    <p>No images available for this package.</p>
                                @else
                                    @foreach ($package->galleries as $gallery)
                                        <img src="{{ $gallery->image_url }}" alt="Image for {{ $package->title }}" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
