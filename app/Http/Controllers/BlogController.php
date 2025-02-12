<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    // Display a list of blogs
    public function index()
    {
        $blogs = Blog::all();
        return view('blogs.index', compact('blogs'));
    }
    public function create()
    {
        return view('blogs.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|unique:blogs,slug|regex:/^[a-z0-9-]+$/',
        'by_user' => 'required',
        'front_image' => 'required|image',
        'content' => 'required'
    ]);

    $blog = new Blog();
    $blog->title = $request->title;
    $blog->slug = Str::slug($request->slug);
    $blog->by_user = $request->by_user;

    if ($request->hasFile('front_image')) {
        $file = $request->file('front_image');
        $filename = time() . '-' . $file->getClientOriginalName();
        $path = Storage::disk('s3')->putFileAs('blogs', $file, $filename);
        $blog->front_image = Storage::disk('s3')->url($path);
    }
    

    $blog->content = $request->content;
    $blog->save();

    return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
}

// Check slug availability (AJAX)
public function checkSlug(Request $request)
{
    $exists = Blog::where('slug', $request->slug)->exists();
    return response()->json(['available' => !$exists]);
}

    public function destroy($id)
{
    $blog = Blog::findOrFail($id);

    // Delete image from S3 if stored
    if ($blog->front_image) {
        Storage::disk('s3')->delete(parse_url($blog->front_image, PHP_URL_PATH));
    }

    $blog->delete();

    return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully!');
}


    public function blogsAPI()
    {
        $blogs = Blog::all();
        return response()->json(['success' => true,'data' => $blogs],200);
    }
    public function show($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }
        return response()->json(['success' => true,'data' => $blog],200);
        

    }

    // Handle Image Upload to S3
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('image');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('blogs', $fileName, 's3');
        $url = Storage::disk('s3')->url($path);

        return response()->json(['url' => $url]);
    }
}

