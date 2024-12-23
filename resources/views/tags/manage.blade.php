<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tags</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="text-center mb-4">Manage Tags for Package</h1>
                
             

                <!-- Add a tag -->
                <div class="card mb-4">
                    <div class="card-header">Add a Tag</div>
                    <div class="card-body">
                        <form action="{{ route('tags.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="pk_Package_id" value="{{ $pk_Package_id }}">
                            <div class="mb-3">
                                <label for="tag" class="form-label">Select Tag</label>
                                <select name="tag" class="form-select">
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->tag }}" {{ in_array($tag->tag, $selectedTags) ? 'disabled' : '' }}>
                                            {{ $tag->tag }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Add Tag</button>
                        </form>
                    </div>
                </div>

                <!-- List assigned tags -->
                <div class="card">
                    <div class="card-header">Assigned Tags</div>
                    <div class="card-body">
                        @if(count($selectedTags) > 0)
                            <ul class="list-group">
                                @foreach($selectedTags as $tagName)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $tagName }}
                                        <form action="{{ route('tags.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="pk_Package_id" value="{{ $pk_Package_id }}">
                                            <input type="hidden" name="tag" value="{{ $tagName }}">
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Remove</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-center">No tags assigned to this package yet.</p>
                        @endif
                    </div>
                    
                    
                    <a href="{{ route('back.to.edit', ['pk_Package_id' => $pk_Package_id]) }}" class="btn btn-secondary">Back to Edit Package</a>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
