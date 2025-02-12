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
            'front_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'by_user'=>'required',
            
        
        ]);
        // Process and store the primary image
    $requestData = $request->except('front_image'); // Get all data except image
    
    // Process and store the image if uploaded
    if ($request->hasFile('front_image')) {
        $file = $request->file('front_image');
        $sanitizedTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->input('title'));
        $fileName = $sanitizedTitle . '.' . $file->getClientOriginalExtension();

        // Store image in S3 and get the URL
        $path = Storage::disk('s3')->putFileAs('packages', $file, $fileName);
        $requestData['front_image'] = Storage::disk('s3')->url($path);
    }

   

    // Redirect with success message
    $requestData = Blog::create($requestData); 

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully!');
    }


    public function destroy(Blog $blog)
    {
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

