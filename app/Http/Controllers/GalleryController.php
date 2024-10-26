<?php
namespace App\Http\Controllers;

use App\Gallery;
use App\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // Show all galleries
    public function index()
{
    // Fetch all packages with their associated galleries
    $packages = Package::with('galleries')->get();

    return view('galleries.index', compact('packages'));
}


    // Show form to create a gallery for a package
    public function create($package_id)
    {
        // Fetch the package by pk_Package_id
        $package = Package::findOrFail($package_id);

        return view('galleries.create', compact('package'));
    }

    // Store gallery images in S3 and save URLs in the database
    public function store(Request $request)
{
    $request->validate([
        'pk_Package_id' => 'required|exists:packages,pk_Package_id',
        'images.*' => 'required|image|max:2048'  // Validate images
    ]);

    foreach ($request->file('images') as $file) {
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = Storage::disk('s3')->putFileAs('galleries', $file, $fileName);

        // Store image URL and package ID in the database
        Gallery::create([
            'pk_Package_id' => $request->pk_Package_id,
            'image_url' => Storage::disk('s3')->url($path),
        ]);
    }

    return redirect()->route('galleries.index')->with('success', 'Images uploaded successfully!');
}

}
