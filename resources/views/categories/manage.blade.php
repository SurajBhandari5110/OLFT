<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="text-center mb-4">Manage Categories for Package</h1>
              

                <!-- Add a category -->
                <div class="card mb-4">
                    <div class="card-header">Add a Category</div>
                    <div class="card-body">
                        <form action="{{ route('categories.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="pk_Package_id" value="{{ $pk_Package_id }}">
                            <div class="mb-3">
                                <label for="category" class="form-label">Select Category</label>
                                <select name="name" class="form-select">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->name }}" {{ in_array($category->name, $selectedCategories) ? 'disabled' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Add Category</button>
                        </form>
                    </div>
                </div>

                <!-- List assigned categories -->
                <div class="card">
                    <div class="card-header">Assigned Categories</div>
                    <div class="card-body">
                        @if(count($selectedCategories) > 0)
                            <ul class="list-group">
                                @foreach($selectedCategories as $categoryName)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $categoryName }}
                                        <form action="{{ route('categories.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="pk_Package_id" value="{{ $pk_Package_id }}">
                                            <input type="hidden" name="name" value="{{ $categoryName }}">
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Remove</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-center">No categories assigned to this package yet.</p>
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
