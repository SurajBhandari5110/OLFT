@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Blog</h2>
    <a href="{{ route('blogs.index') }}" class="btn btn-secondary mb-3">Back to Blogs</a>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" required onkeyup="generateSlug()">
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control" required>
            <small id="slug-error" class="text-danger"></small>
        </div>

        <div class="mb-3">
            <label for="by_user" class="form-label">Author (User ID)</label>
            <input type="text" name="by_user" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="front_image">Front Image</label>
            <input type="file" name="front_image" id="front_image" class="form-control" required accept="image/*">
            <label for="image" style="font-size:12px; color:red;">Image size must be 500KB or less!</label>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <div id="editor">{!! $blog->content ?? '' !!}</div>
            <input type="hidden" name="content" id="content">
        </div>

        <button type="submit" class="btn btn-success">Submit Blog</button>
    </form>
</div>

<!-- Quill JS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    var quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Write something...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['image'],
                ['clean']
            ]
        }
    });

    function generateSlug() {
        let title = document.getElementById('title').value;
        let slug = title.toLowerCase().trim()
                        .replace(/[^a-z0-9\s-]/g, '')  // Remove special characters except spaces and hyphens
                        .replace(/\s+/g, '-')          // Convert spaces to dashes
                        .replace(/-+/g, '-');          // Remove duplicate dashes
        
        document.getElementById('slug').value = slug;
        checkSlugAvailability(slug);
    }

    function checkSlugAvailability(slug) {
        if (!slug.match(/^[a-z0-9-]+$/)) {
            document.getElementById('slug-error').textContent = "Slug can only contain lowercase letters, numbers, and dashes (-).";
            return;
        }

        fetch("{{ route('blogs.checkSlug') }}?slug=" + slug)
            .then(response => response.json())
            .then(data => {
                if (!data.available) {
                    document.getElementById('slug-error').textContent = "This slug is already taken.";
                } else {
                    document.getElementById('slug-error').textContent = "";
                }
            });
    }

    document.querySelector('form').onsubmit = function() {
        document.querySelector("#content").value = quill.root.innerHTML;
    };
</script>
@endsection
