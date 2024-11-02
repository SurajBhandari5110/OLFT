@extends('voyager::master')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <h1>Create Itineraries for Package: {{ $package->title }}</h1>

        <!-- Dropdown for copying itineraries from other packages -->
        <div class="form-group">
            <label for="copy-itineraries">Copy Itineraries from another package:</label>
            <select id="copy-itineraries" class="form-control">
                <option value="">Select Package to Copy</option>
                @foreach ($matchingPackages as $matchingPackage)
                    <option value="{{ $matchingPackage->pk_Package_id }}">{{ $matchingPackage->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Form for creating itineraries -->
        <form action="{{ route('save.itinerary') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="pk_Package_id" value="{{ $package->pk_Package_id }}">
            <input type="hidden" name="copy_from_package_id" id="copy_from_package_id" value="">

            <div id="itinerary-container">
                @for ($day = 1; $day <= $duration; $day++)
                    <div class="form-group">
                        <label for="day">Day {{ $day }}</label>
                        <input type="hidden" name="itineraries[{{ $day }}][days]" value="{{ $day }}">

                        <div class="row">
                            <div class="col-md-4">
                                <label for="title">Title for Day {{ $day }}:</label>
                                <input type="text" name="itineraries[{{ $day }}][title]" class="form-control" placeholder="Enter title for day {{ $day }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="description">Description for Day {{ $day }}:</label>
                                <textarea name="itineraries[{{ $day }}][description]" class="form-control" placeholder="Enter description for day {{ $day }}" required></textarea>
                            </div>

                            <div class="col-md-4">
                                <label for="image">Image for Day {{ $day }} (Optional):</label>
                                <input type="file" name="itineraries[{{ $day }}][image]" class="form-control">
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <button type="submit" class="btn btn-primary">Save Itineraries</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('copy-itineraries').addEventListener('change', function() {
        const selectedPackageId = this.value;
        document.getElementById('copy_from_package_id').value = selectedPackageId;

        if (selectedPackageId) {
            fetch(`/packages/${selectedPackageId}/itineraries`)
                .then(response => response.json())
                .then(data => {
                    const itineraryContainer = document.getElementById('itinerary-container');
                    itineraryContainer.innerHTML = '';

                    data.itineraries.forEach((itinerary, index) => {
                        const day = index + 1;
                        itineraryContainer.innerHTML += `
                            <div class="form-group">
                                <label for="day">Day ${day}</label>
                                <input type="hidden" name="itineraries[${day}][days]" value="${day}">
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="title">Title for Day ${day}:</label>
                                        <input type="text" name="itineraries[${day}][title]" class="form-control" value="${itinerary.title}" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="description">Description for Day ${day}:</label>
                                        <textarea name="itineraries[${day}][description]" class="form-control" required>${itinerary.description}</textarea>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="image">Image for Day ${day} (Optional):</label>
                                        <input type="hidden" name="itineraries[${day}][image_url]" value="${itinerary.image}"> <!-- Keep the URL -->
                                        <input type="file" name="itineraries[${day}][image]" class="form-control">
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                });
        }
    });
</script>
@endsection
