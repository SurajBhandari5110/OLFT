@extends('voyager::master')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <h1>Galleries for Packages</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Package ID</th>
                    <th>Package Title</th>
                    <th>Images</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($packages as $package)
                    <tr>
                        <td>{{ $package->pk_Package_id }}</td>
                        <td>{{ $package->title }}</td>
                        <td>
                            @if ($package->galleries->isEmpty())
                                <p>No images available for this package.</p>
                            @else
                                @foreach ($package->galleries as $gallery)
                                    <div class="gallery-item" style="display: inline-block; margin-right: 10px;">
                                        <img src="{{ $gallery->image_url }}" alt="Image for {{ $package->title }}" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                        <form action="{{ route('packages.deleteGalleryImage', $gallery->id) }}" method="POST" style="margin-top: 5px;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#uploadImageModal" data-package-id="{{ $package->pk_Package_id }}">
                                Add Images
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for uploading images -->
<div class="modal fade" id="uploadImageModal" tabindex="-1" role="dialog" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadImageModalLabel">Upload Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('packages.uploadGalleryImage') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="package_id" id="packageIdInput">
                    <input type="hidden" name="cropped_image" id="croppedImage">
                    <div class="form-group">
                        <input type="file" class="form-control-file" id="galleryImage" name="gallery_image" required>
                        <label for="galleryImage" style="font-size:12px; color:red;">Image size must be 500KB or less!</label>
                    </div>
                    <div id="cropperContainer" style="display:none;">
                        <img id="imagePreview" style="max-width: 100%;">
                    </div>
                    <div>
                        <button type="button" class="btn btn-success" id="cropImageButton" style="display:none;">Crop</button>
                        <button type="submit" class="btn btn-primary" id="uploadImageButton" style="display:none;">Confirm Upload</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<!-- Include Cropper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    var cropper;
    var cropperContainer = document.getElementById('cropperContainer');
    var imagePreview = document.getElementById('imagePreview');
    var galleryImage = document.getElementById('galleryImage');
    var cropImageButton = document.getElementById('cropImageButton');
    var uploadImageButton = document.getElementById('uploadImageButton');
    var croppedImageInput = document.getElementById('croppedImage');

    galleryImage.addEventListener('change', function (event) {
        var file = event.target.files[0];
        if (file && file.size > 512 * 1024) {
            alert('The selected file is too large. Please upload an image of 500 KB or less.');
            event.target.value = '';
            return;
        }

        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                cropperContainer.style.display = 'block';
                cropImageButton.style.display = 'block';
                uploadImageButton.style.display = 'none';

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(imagePreview, {
                    aspectRatio: 950 / 650,
                    viewMode: 1,
                });
            };
            reader.readAsDataURL(file);
        }
    });

    cropImageButton.addEventListener('click', function () {
        if (cropper) {
            var canvas = cropper.getCroppedCanvas({
                width: 950,
                height: 650,
            });
            croppedImageInput.value = canvas.toDataURL('image/jpeg');
            cropImageButton.style.display = 'none';
            uploadImageButton.style.display = 'block';
            alert('Image cropped successfully. Click "Confirm Upload" to save.');
        }
    });

    // Pass the package ID to the modal
    $('#uploadImageModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var packageId = button.data('package-id');
        var modal = $(this);
        modal.find('#packageIdInput').val(packageId);
    });
</script>
@endsection
