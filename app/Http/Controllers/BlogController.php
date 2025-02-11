<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'title' => 'required|unique:blogs,title',
            'content' => 'required',
            'slug' => 'required|unique:blogs,slug',
            'by_user'=>'required',
        
        ]);

        Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'by_user'=>$request->by_user,
        ]);

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully!');
    }


    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully!');
    }

    public function blogsAPI()
    {
        return response()->json(Blog::latest()->get());
    }
    public function show($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        return response()->json($blog);
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

