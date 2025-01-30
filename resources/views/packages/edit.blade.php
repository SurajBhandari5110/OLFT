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
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Edit Package</h1>
    <a href="{{ route('packages.index') }}" class="btn btn-outline-info btn-lg">View All Packages</a>
</div>

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
            <label for="country">Country</label>
    <select name="country" id="country" class="form-control" required>
    <option value="" disabled selected>Select a Country</option>
    @foreach($countries as $country)
        <option value="{{ $country->name }}">{{ $country->name }}</option>
    @endforeach
    </select>
            </div>

            <div class="form-group">
                <label for="state">State</label>
                <input type="text" name="state" class="form-control" value="{{ $package->state }}" required>
            </div>


            <div class="form-group">
                <label for="duration">Duration</label>
                <input type="number" name="duration" class="form-control" value="{{ $package->duration }}" required>
            </div>

            <div class="form-group">
            <label>Tour Type</label><br>
            <select name="tour_type" id="tour_type" class="form-control" required>
            <option value="Adventure">Adventure</option>
            <option value="City Tour">City Tour</option>
            <option value="Couple">Couple</option>
            <option value="Escorted Tour">Escorted Tour</option>
            <option value="Family">Family</option>
            <option value="Hill Town">Hill Town</option></select>
            </div>

            <div class="form-group">
                <label for="group_size">Group Size</label>
                <input type="number" name="group_size" class="form-control" value="{{ $package->group_size }}" required>
            </div>

            <div class="form-group">
                <label for="tour_guide">Number of Tour Guides</label>
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
    <a href="{{ route('inclusions.manage', ['packageId' => $package->pk_Package_id]) }}" class="btn btn-success btn-lg">Manage Inclusions</a>
    <a href="{{ route('package_stays.create', ['pk_Package_id' => $package]) }}" class="btn btn-primary btn-lg">Add Stays</a>
    <a href="{{ route('categories.manage', ['pk_Package_id' => $package]) }}" class="btn btn-warning btn-lg">Manage Categories</a>
    <a href="{{ route('tags.manage', ['pk_Package_id' => $package->pk_Package_id]) }}" class="btn btn-info btn-lg">Manage Tags</a>

   

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
                <label for="image" style="font-size:12px; color:red;">Image size must be 500KB or less!</label>
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

    // Validate image size
    function validateImageSize(event) {
        if (imageInput.files.length > 0) {
            const fileSize = imageInput.files[0].size / 1024; // Size in KB
            if (fileSize > 500) {
                event.preventDefault();
                alert('Image size must be 500KB or less. Please upload a smaller image.');
                return false; // Stop further execution
            }
        }
        return true;
    }

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
            const fileSize = file.size / 1024; // Size in KB
            if (fileSize > 500) {
                alert('Image size must be 500KB or less. Please upload a smaller image.');
                resetCropper();
                imageInput.value = ''; // Clear the input field
                return;
            }

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

    // Crop and update input file
    cropConfirmButton.addEventListener('click', () => {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas();
            canvas.toBlob((blob) => {
                const croppedFile = new File([blob], 'cropped-image.jpg', { type: 'image/jpeg' });

                // Update the input field with the cropped file
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(croppedFile);
                imageInput.files = dataTransfer.files;

                // Hide preview and button after crop
                imagePreview.style.display = 'none';
                cropConfirmButton.style.display = 'none';
            }, 'image/jpeg');
        }
    });

    // Reset cropper on form reset
    document.querySelector('form').addEventListener('reset', resetCropper);

    // Attach validation to the form submission
    document.querySelector('form').addEventListener('submit', validateImageSize);
</script>
</body>
</html>
