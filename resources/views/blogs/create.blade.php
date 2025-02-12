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
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="by_user" class="form-label">Author (User ID)</label>
            <input type="text" name="by_user" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="front_image">Front image of this blog</label>
            <input type="file" name="front_image" id="front_image" class="form-control" required accept="image/*">
            <label for="image" style="font-size:12px; color:red;">Image size must be 500KB or less!</label>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <div id="editor">{!! $blog->content ?? '' !!}</div>
            <input type="hidden" name="content" id="content">
        </div>

        <button type="submit" class="btn btn-success">Blog</button>
    </form>
</div>

<!-- Quill JS & Styles -->
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

    // Handle Image Upload
    quill.getModule('toolbar').addHandler('image', function() {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.click();

        input.onchange = function() {
            var file = input.files[0];
            var formData = new FormData();
            formData.append('image', file);

            fetch("{{ route('blogs.uploadImage') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.url) {
                    let range = quill.getSelection();
                    quill.insertEmbed(range.index, 'image', data.url);
                }
            })
            .catch(error => console.error(error));
        };
    });

    document.querySelector('form').onsubmit = function() {
        document.querySelector("#content").value = quill.root.innerHTML;
    };
</script>
@endsection