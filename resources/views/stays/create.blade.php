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
<body></body>
    <div class="container">
        <h1>Create New Stay</h1>
        <form action="{{ route('voyager.stays.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" class="form-control" id="country" name="country" required>
            </div>
            <div class="form-group">
                <label for="state">State</label>
                <input type="text" class="form-control" id="state" name="state" required>
            </div>
            <label for="image">Upload Image</label>
        <div class="form-group">
                
                <input type="file" name="image" class="form-control-file" id="image-input">
            </div>

            <div class="crop-container">
                <img id="image-preview" alt="Image Preview" style="max-width: 100%; display: none;">
                <button type="button" id="crop-confirm-button" class="btn btn-primary mt-2" style="display:none;">Confirm Crop</button>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
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
                    const croppedFile = new File([blob], 'new', { type: 'image/jpeg' });

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
