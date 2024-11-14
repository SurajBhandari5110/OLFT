<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Package</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <style>
        .crop-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Package</h1>

        <!-- Display success or error messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('packages.update', $package->pk_Package_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $package->title }}" required>
            </div>

            <div class="form-group">
                <label for="about">About</label>
                <textarea name="about" class="form-control" rows="5" required>{{ $package->about }}</textarea>
            </div>

            <div class="form-group">
                <label for="location">Country</label>
                <input type="text" name="location" class="form-control" value="{{ $package->country }}" required>
            </div>
            <div class="form-group">
                <label for="location">State</label>
                <input type="text" name="location" class="form-control" value="{{ $package->state }}" required>
            </div>

            <div class="form-group">
                <label for="duration">Duration</label>
                <input type="text" name="duration" class="form-control" value="{{ $package->duration }}" required>
            </div>

            <div class="form-group">
                <label for="tour_type">Tour Type</label>
                <input type="text" name="tour_type" class="form-control" value="{{ $package->tour_type }}" required>
            </div>

            <div class="form-group">
                <label for="group_size">Group Size</label>
                <input type="number" name="group_size" class="form-control" value="{{ $package->group_size }}" required>
            </div>

            <div class="form-group">
                <label for="tour_guide">Tour Guide</label>
                <input type="text" name="tour_guide" class="form-control" value="{{ $package->tour_guide }}" required>
            </div>

            <div class="form-group">
                <label for="coordinates">Coordinates</label>
                <input type="text" name="coordinates" class="form-control" value="{{ $package->coordinates }}">
            </div>

            <div class="form-group">
                <label for="travel_with_bus">Travel with Bus</label>
                <select name="travel_with_bus" class="form-control">
                    <option value="1" {{ $package->travel_with_bus == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ $package->travel_with_bus == 0 ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="stays">Stays</label>
                <input type="text" name="coordinates" class="form-control" value="{{ $package->stays }}">
            </div>

            <div class="form-group">
                <label for="image">Current Image</label><br>
                @if ($package->image)
                    <img src="{{ asset($package->image) }}" alt="{{ $package->title }}" class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                @else
                    <p>No image available</p>
                @endif
            </div>

            <div class="form-group">
                <label for="image">Upload New Image</label>
                <input type="file" name="image" class="form-control-file" id="image-input">
            </div>

            <div class="crop-container">
                <img id="image-preview" alt="Image Preview" style="max-width: 100%; display: none;">
                <button type="button" id="crop-confirm-button" class="btn btn-primary mt-2" style="display:none;">Confirm Crop</button>
            </div>

            <button type="submit" class="btn btn-primary">Update Package</button>
            <a href="{{ route('packages.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <script>
        let cropper;
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        const cropConfirmButton = document.getElementById('crop-confirm-button');

        // Reset cropper function
        function resetCropper() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            imagePreview.style.display = 'none';
            cropConfirmButton.style.display = 'none';
            imagePreview.src = '';
        }

        // Initialize cropper on selecting a file
        imageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    resetCropper();

                    imagePreview.src = event.target.result;
                    imagePreview.style.display = 'block';
                    cropConfirmButton.style.display = 'inline-block';

                    cropper = new Cropper(imagePreview, {
                        aspectRatio: 1,
                        viewMode: 2,
                        autoCropArea: 1,
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        cropConfirmButton.addEventListener('click', () => {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas();
                canvas.toBlob((blob) => {
                    const croppedFile = new File([blob], value="{{$package->pk_Package_id}}", { type: 'image/jpeg' });

                    // Update the input field with the cropped file
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(croppedFile);
                    imageInput.files = dataTransfer.files;

                    // Hide preview and button after crop
                    imagePreview.style.display = 'none';
                    cropConfirmButton.style.display = 'none';
                }, 'image/jpeg/png');
            }
        });

        // Reset cropper on form reset
        document.querySelector('form').addEventListener('reset', resetCropper);
    </script>

</body>
</html>
