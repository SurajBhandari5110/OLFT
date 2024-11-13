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
                        <th>Action</th> <!-- New column for the "Add Image" button -->
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
                                        <img src="{{ $gallery->image_url }}" alt="Image for {{ $package->title }}" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <!-- Add Image button that opens a modal -->
                                <button class="btn btn-primary" data-toggle="modal" data-target="#uploadImageModal" data-package-id="{{ $package->pk_Package_id }}">
                                    Add Image
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
                        <div class="form-group">
                            <label for="galleryImage">Select Image</label>
                            <input type="file" class="form-control-file" id="galleryImage" name="gallery_image" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload Image</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        // Pass the package ID to the modal
        $('#uploadImageModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var packageId = button.data('package-id');
            var modal = $(this);
            modal.find('#packageIdInput').val(packageId);
        });
    </script>
@endsection
