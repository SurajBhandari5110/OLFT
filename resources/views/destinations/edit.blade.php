@extends('voyager::master')

@section('content')
<div class="container">
    <h1>Edit Destination</h1>
    <form id="edit-destination-form" action="{{ route('destinations.update', $destination) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="country">Country</label>
            <select name="country" id="country" class="form-control" required>
                @foreach ($countries as $country)
                <option value="{{ $country->name }}" {{ $destination->country == $country->name ? 'selected' : '' }}>
                    {{ $country->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="image">Upload New Image</label>
            <input type="file" name="image" class="form-control-file" id="image-input">
            <small style="font-size:12px; color:red;">Image size must be 500KB or less!</small>

            @if ($destination->image)
            <div class="mt-2">
                <label>Current Image:</label>
                <img src="{{ $destination->image }}" alt="Current Image" width="100" class="mt-2">
            </div>
            @endif

            <div class="crop-container mt-3">
                <img id="image-preview" alt="Image Preview" style="max-width: 100%; display: none;">
                <button type="button" id="crop-confirm-button" class="btn btn-primary mt-2" style="display:none;">Confirm Crop</button>
            </div>
        </div>
        <div class="form-group">
            <label for="about">About</label>
            <textarea name="about" id="about" class="form-control">{{ $destination->about }}</textarea>
        </div>
        <div class="form-group">
            <label for="attraction">Attraction</label>
            <textarea name="attraction" id="attraction" class="form-control">{{ $destination->attraction }}</textarea>
        </div>
        <div class="form-group">
            <label for="coordinates">Coordinates</label>
            <input type="text" name="coordinates" id="coordinates" class="form-control" value="{{ $destination->coordinates }}">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
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
@endsection
