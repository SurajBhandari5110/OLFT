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

    // Show form to create a new blog
    public function create()
    {
        return view('blogs.create');
    }

    // Store a new blog in the database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'by_user' => 'required|string|max:255',
            'comment' => 'nullable|string',
            'primary_image' => 'required|image|max:2048',
            'secondary_image' => 'nullable|image|max:2048',
            'moto1' => 'nullable|string',
            'para1' => 'nullable|string',
            'moto2' => 'nullable|string',
        ]);

        $requestData = $request->except(['primary_image', 'secondary_image']);

        // Process and store the primary image
        if ($request->hasFile('primary_image')) {
            $primaryFile = $request->file('primary_image');
            $primaryFileName = time() . '_primary_' . $primaryFile->getClientOriginalName();
            $primaryPath = Storage::disk('s3')->putFileAs('blogs', $primaryFile, $primaryFileName);
            $requestData['primary_image'] = Storage::disk('s3')->url($primaryPath);
        }

        // Process and store the secondary image
        if ($request->hasFile('secondary_image')) {
            $secondaryFile = $request->file('secondary_image');
            $secondaryFileName = time() . '_secondary_' . $secondaryFile->getClientOriginalName();
            $secondaryPath = Storage::disk('s3')->putFileAs('blogs', $secondaryFile, $secondaryFileName);
            $requestData['secondary_image'] = Storage::disk('s3')->url($secondaryPath);
        }

        Blog::create($requestData);

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully!');
    }

    // Show form to edit an existing blog
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blogs.edit', compact('blog'));
    }

    // Update an existing blog in the database
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'by_user' => 'required|string|max:255',
            'comment' => 'nullable|string',
            'primary_image' => 'nullable|image|max:2048',
            'secondary_image' => 'nullable|image|max:2048',
            'moto1' => 'nullable|string',
            'para1' => 'nullable|string',
            'para2' => 'nullable|string',
            'moto2' => 'nullable|string',
        ]);

        $requestData = $request->except(['primary_image', 'secondary_image']);

        // Process and update the primary image
        if ($request->hasFile('primary_image')) {
            if ($blog->primary_image) {
                Storage::disk('s3')->delete(parse_url($blog->primary_image, PHP_URL_PATH));
            }

            $primaryFile = $request->file('primary_image');
            $primaryFileName = time() . '_primary_' . $primaryFile->getClientOriginalName();
            $primaryPath = Storage::disk('s3')->putFileAs('blogs', $primaryFile, $primaryFileName);
            $requestData['primary_image'] = Storage::disk('s3')->url($primaryPath);
        }

        // Process and update the secondary image
        if ($request->hasFile('secondary_image')) {
            if ($blog->secondary_image) {
                Storage::disk('s3')->delete(parse_url($blog->secondary_image, PHP_URL_PATH));
            }

            $secondaryFile = $request->file('secondary_image');
            $secondaryFileName = time() . '_secondary_' . $secondaryFile->getClientOriginalName();
            $secondaryPath = Storage::disk('s3')->putFileAs('blogs', $secondaryFile, $secondaryFileName);
            $requestData['secondary_image'] = Storage::disk('s3')->url($secondaryPath);
        }

        $blog->update($requestData);

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully!');
    }

    // Delete an existing blog
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->primary_image) {
            Storage::disk('s3')->delete(parse_url($blog->primary_image, PHP_URL_PATH));
        }

        if ($blog->secondary_image) {
            Storage::disk('s3')->delete(parse_url($blog->secondary_image, PHP_URL_PATH));
        }

        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully!');
    }

    public function fetchBlog()
{
    // Fetch all blogs from the database
    $blogs = Blog::all();

    // Return the blogs to a view
    //return view('blogs.index', compact('blogs'));
    return response()->json([
        'success' => true,
        'data' => $blogs,
    ]);
}
public function show($id)
{
    // Find the blog by ID or throw a 404 error if not found
    $blog = Blog::findOrFail($id);

    // Return the blog data to a view
    //return view('blogs.show', compact('blog'));
    return response()->json([
        'success' => true,
        'data' => $blog,
    ]);
}


}
