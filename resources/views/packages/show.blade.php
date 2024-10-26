@extends('packages.layout')
@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Tour Information</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <!-- Package Title -->
            <h2 class="card-title text-center">{{ $package->title }}</h2>

            <!-- Package Description -->
            <p class="mt-3">{{ $package->about }}</p>

            <!-- Package Image -->
            <div class="text-center my-4">
                <img src="{{ asset($package->image) }}" alt="{{ $package->title }}" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
            </div>

            <!-- Package Details Table -->
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Destination</th>
                        <td>{{ $package->title }}</td>
                    </tr>
                    <tr>
                        <th>Travel With Bus</th>
                        <td>{{ $package->travel_with_bus ? 'Yes' : 'No' }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Inclusion and Exclusion Tables -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <h3 class="text-center">Included Benefits</h3>
                    <table class="table table-bordered">
                        <tbody>
                            @forelse ($package->inclusions->where('isActive', 1) as $inclusion)
                                <tr>
                                    <td>{{ $inclusion->include->Name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center">No inclusions available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="col-md-6">
                    <h3 class="text-center">Excluded Benefits</h3>
                    <table class="table table-bordered">
                        <tbody>
                            @forelse ($package->inclusions->where('isActive', 0) as $exclusion)
                                <tr>
                                    <td>{{ $exclusion->include->Name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center">No exclusions available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
