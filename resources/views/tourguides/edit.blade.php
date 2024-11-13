<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tour Guide</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <style>
        #image-preview {
            max-width: 100%;
            display: none;
        }
        .crop-container {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Tour Guide</h1>

        <form action="{{ route('tourguides.update', $tourguide->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="captain">Captain Name</label>
                <input type="text" name="captain" class="form-control" value="{{ $tourguide->captain }}" required>
            </div>

            <div class="form-group">
                <label for="phn_number">Phone Number</label>
                <input type="text" name="phn_number" class="form-control" value="{{ $tourguide->phn_number }}" required>
            </div>

            <div class="form-group">
                <label for="insta">Instagram</label>
                <input type="text" name="insta" class="form-control" value="{{ $tourguide->insta }}">
            </div>

            <div class="form-group">
                <label for="image">Upload New Image</label>
                <input type="file" name="image" id="image-input" class="form-control-file" required>
                <div class="mt-2">
                    <img id="image-preview" alt="Image Preview">
                </div>
            </div>

            <div class="crop-container mt-3">
                <button type="button" id="crop-confirm-button" class="btn btn-primary">Confirm Crop</button>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Tour Guide</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        let cropper;
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        const cropContainer = document.querySelector('.crop-container');
        const cropConfirmButton = document.getElementById('crop-confirm-button');

        // Initialize the cropper when a new file is selected
        imageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    imagePreview.src = event.target.result;
                    imagePreview.style.display = 'block';
                    cropContainer.style.display = 'block';
                    initCropper(imagePreview);
                };
                reader.readAsDataURL(file);
            }
        });

        function initCropper(imageElement) {
            if (cropper) {
                cropper.destroy(); // Destroy any existing cropper instance
            }
            cropper = new Cropper(imageElement, {
                aspectRatio: 1,
                viewMode: 2,
                autoCropArea: 1,
            });
        }

        cropConfirmButton.addEventListener('click', () => {
            const canvas = cropper.getCroppedCanvas();
            canvas.toBlob((blob) => {
                const croppedFile = new File([blob], value={{$tourguide->id}}, { type: 'image/jpeg' });

                // Prepare the cropped image for upload
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(croppedFile);
                imageInput.files = dataTransfer.files;

                cropContainer.style.display = 'none';
                imagePreview.style.display = 'none';
            }, 'image/jpeg');
        });
    </script>
</body>
</html>
