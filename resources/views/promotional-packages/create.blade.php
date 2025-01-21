@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2>Create Promotional Package</h2>
        </div>
        <div class="card-body">

            <!-- Form to select a country -->
            <form method="GET" action="{{ route('promotional-packages.create') }}" class="mb-4">
                <div class="form-group">
                    <label for="country" class="font-weight-bold">Select Country</label>
                    <select id="country" name="country" class="form-control" onchange="this.form.submit()">
                        <option value="">Choose a country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->country }}" {{ request('country') == $country->country ? 'selected' : '' }}>
                                {{ $country->country }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>

            <!-- If packages are available, show the package selection form -->
            @if($packages->count())
                <form method="POST" action="{{ route('promotional-packages.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="pk_Package_id" class="font-weight-bold">Select Package</label>
                        <select id="pk_Package_id" name="pk_Package_id" class="form-control">
                            @foreach($packages as $package)
                                <option value="{{ $package->pk_Package_id }}">{{ $package->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- User inputs for generating dynamic slug -->
                    <div class="form-group">
                        <label for="dynamic-url" class="font-weight-bold">Create Dynamic URL:</label>
                        <input type="text" name="dynamic-url" id="dynamic-url" class="form-control" placeholder="Ex:India/Goa" required>
                    </div>

                    

                    <button type="submit" class="btn btn-success btn-block mt-3">Generate URL and Store</button>
                </form>
            @else
                @if(request('country'))
                    <div class="alert alert-warning mt-4">
                        No packages found for the selected destination.
                    </div>
                @endif
            @endif

            <!-- Success message -->
            @if(session('success'))
                <div class="alert alert-success mt-4">
                    {{ session('success') }}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
