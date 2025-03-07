<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Destination</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <style>
        .crop-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Create New Destination</h1>
    <form action="{{ route('destinations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
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
            <label for="image">Upload Image</label>
            <input type="file" name="image" class="form-control-file" id="image-input">
            <small style="font-size:12px; color:red;">Image size must be 500KB or less!</small>

            <div class="crop-container">
                <img id="image-preview" alt="Image Preview" style="max-width: 100%; display: none;">
                <button type="button" id="crop-confirm-button" class="btn btn-primary mt-2" style="display:none;">Confirm Crop</button>
            </div>
        </div>
        <div class="form-group">
            <label for="about">About</label>
            
            <textarea name="about" id="about" placeholder="Write about place under 500 words" class="form-control" rows="6" required oninput="checkWordLimit()"></textarea><br>
     <!-- Word Count Display -->
     <p><strong>Word Count:</strong> <span id="word_count">0</span>/500</p>

<!-- Error Message -->
<p style="color:red;" id="error_message" class="error-message"></p>
        </div>
        <div class="form-group">
            <label for="attraction">Attraction</label>
            <textarea name="attraction" id="attraction" class="form-control" placeholder="Which Place Attract Tourist To This Country" oninput="checkWordLimit1()"></textarea>
             <!-- Word Count Display -->
     <p><strong>Word Count:</strong> <span id="word_count1">0</span>/500</p>

<!-- Error Message -->
<p style="color:red;" id="error_message1" class="error-message"></p>
        </div>
        <div class="form-group">
            <label for="coordinates">Location</label>
            <input type="text" name="coordinates" id="coordinates" class="form-control">
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
    
    //Checkword counts on About Package:
    function checkWordLimit() {
            let inputField = document.getElementById("about");
            let wordCountDisplay = document.getElementById("word_count");
            let errorMessage = document.getElementById("error_message");

            // Get input text and split it into words
            let words = inputField.value.trim().split(/\s+/);
            let wordCount = words.length;

            // Update word count display
            wordCountDisplay.innerText = wordCount;

            // Check if word limit exceeded
            if (wordCount > 500) {
                errorMessage.innerText = "500 words exceeded!";
                inputField.value = words.slice(0, 500).join(" "); // Trim extra words
                wordCountDisplay.innerText = 500; // Lock word count at 500
            } else {
                errorMessage.innerText = ""; // Clear error if within limit
            }
        }
        //Checkword count for Attraction:
        //Checkword counts on About Package:
    function checkWordLimit1() {
            let inputField = document.getElementById("attraction");
            let wordCountDisplay = document.getElementById("word_count1");
            let errorMessage = document.getElementById("error_message1");

            // Get input text and split it into words
            let words = inputField.value.trim().split(/\s+/);
            let wordCount = words.length;

            // Update word count display
            wordCountDisplay.innerText = wordCount;

            // Check if word limit exceeded
            if (wordCount > 500) {
                errorMessage.innerText = "500 words exceeded!";
                inputField.value = words.slice(0, 500).join(" "); // Trim extra words
                wordCountDisplay.innerText = 500; // Lock word count at 500
            } else {
                errorMessage.innerText = ""; // Clear error if within limit
            }
        }
</script>
</body>
</html>
