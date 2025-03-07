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
       
  <form action="{{ url('packages/store') }}" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}

    <label>Title</label><br>
    <input type="text" name="title" id="title" placeholder="Example: Abmber Palce" class="form-control" required><br>

    <label>About Place</label><br>
    <textarea name="about" id="about" placeholder="Write about place under 500 words" class="form-control" rows="6" required oninput="checkWordLimit()"></textarea><br>
     <!-- Word Count Display -->
     <p><strong>Word Count:</strong> <span id="word_count">0</span>/500</p>

<!-- Error Message -->
<p style="color:red;" id="error_message" class="error-message"></p>

    
    <label for="country">Country</label>
    <select name="country" id="country" class="form-control" required>
    <option value="" disabled selected>Select a Country</option>
    @foreach($countries as $country)
        <option value="{{ $country->name }}">{{ $country->name }}</option>
    @endforeach
    </select><br>
    

    <label>State</label><br>
    <input type="text" name="state" id="state" class="form-control" placeholder="Example: Uttarakhand" required><br>
    
    <label>Duration</label><br>
    <input type="number" name="duration" id="duration" class="form-control" placeholder="Enter number of days" required oninput="calculateDuration()"><br><!-- Display Result -->
    <p><strong>Total Duration:</strong> <span id="total_duration"></span></p>


    <label>Tour Type</label><br>
    <select name="tour_type" id="tour_type" class="form-control" required>
    <option value="Adventure">Adventure</option>
    <option value="City Tour">City Tour</option>
    <option value="Couple">Couple</option>
    <option value="Escorted Tour">Escorted Tour</option>
    <option value="Family">Family</option>
    <option value="Hill Town">Hill Town</option></select><br>

    <label>Group Size</label><br>
    <input type="number" name="group_size" id="group_size" class="form-control" placeholder="Number of People" required><br>

    <label>Captains</label><br>
    <input type="number" name="tour_guide" id="tour_guide" class="form-control" placeholder="Number of Tour-Guides" required><br>

    <label>Location</label><br>
    <input type="text" name="coordinates" id="coordinates" placeholder="Add Google Map Link of the place" class="form-control"><br>

    <label>Travel With Bus</label><br>
    <select name="travel_with_bus" id="travel_with_bus" placeholder="Yes or No"
    class="form-control" required>
    <option value="Yes">Yes</option>
    <option value="No">No</option></select><br>


        <label for="image">Upload Image</label>
        <div class="form-group">
                
                <input type="file" name="image" class="form-control-file" id="image-input">
            </div>
            <label for="image" style="font-size:12px; color:red;">Image size must be 500KB or less!</label>

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

    //Logic for days and night: --
    function calculateDuration() {
            let days = parseInt(document.getElementById('duration').value);
            let resultElement = document.getElementById('total_duration');

            if (!isNaN(days) && days > 0) {
                let nights = days + 1; 
                resultElement.innerText = ` ${days} Days ${nights} Nights`;
            } else {
                resultElement.innerText = "";
            }
        }
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
</script>

</body>
</html>