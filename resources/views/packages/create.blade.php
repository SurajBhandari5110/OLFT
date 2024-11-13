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
  
<div class="card" style="margin: 20px;">
  <div class="card-header">Create New Package</div>
  <div class="card-body">
       
      <form action="{{ url('packages') }}" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <label>Title</label></br>
        <input type="text" name="title" id="title" class="form-control"></br>
        <label>About Place</label></br>
        <input type="text" name="about" id="about" class="form-control"></br>
        <label>Destination Loaction</label></br>
        <input type="text" name="location" id="location" class="form-control"></br>
        <label>Duration</label></br>
        <input type="number" name="duration" id="duration" class="form-control"></br>
        <label>Tour-type</label></br>
        <input type="text" name="tour_type" id="tour_type" class="form-control"></br>
        <label>Group Size</label></br>
        <input type="number" name="tour_type" id="group_size" class="group_size">
        </br>
        <label>Tour Guide</label></br>
        <input type="number" name="tour_guide" id="tour_guide" class="group_size"> </br>
        <label>Travel With Bus</label></br>
        <input type="text" name="travel_with_bus" id="travel_with_bus" class="form-control"></br>
        <label for="image">Upload Image</label>
        <div class="form-group">
                
                <input type="file" name="image" class="form-control-file" id="image-input">
            </div>

            <div class="crop-container">
                <img id="image-preview" alt="Image Preview" style="max-width: 100%; display: none;">
                <button type="button" id="crop-confirm-button" class="btn btn-primary mt-2" style="display:none;">Confirm Crop</button>
            </div>
            
            
            
        <input type="submit" value="Save" class="btn btn-success"></br>
    </form>
   
  </div>
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
                    const croppedFile = new File([blob], "new", { type: 'image/jpeg' });

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
    </script>
</body>
</html>