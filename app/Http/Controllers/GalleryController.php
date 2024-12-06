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
            'pk_Package_id' => 'required|exists:packages,pk_Package_id', // Ensure package exists
            'image' => 'required|image|max:2048'  // Validate single image
        ]);

        // Generate a unique name for the image file
        $file = $request->file('image');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

        // Upload file to S3 with the unique name
        $path = Storage::disk('s3')->putFileAs('galleries', $file, $fileName);

        // Save the image URL and package ID in the database
        Gallery::create([
            'pk_Package_id' => $request->pk_Package_id,
            'image_url' => Storage::disk('s3')->url($path),
        ]);

        return redirect()->route('galleries.index')->with('success', 'Image uploaded successfully!');
    }
public function deleteGalleryImage($id)
{
    $gallery = Gallery::findOrFail($id);

    // Delete the file from S3
    Storage::disk('s3')->delete($gallery->image_url);

    // Delete the database record
    $gallery->delete();

    return redirect()->back()->with('success', 'Image deleted successfully.');
}
// Fetch all galleries for a specific package by package_id
public function fetchByPackageId($package_id)
{
    // Validate if the package exists
    $package = Package::findOrFail($package_id);

    // Fetch all gallery images associated with the package
    $galleries = Gallery::where('pk_Package_id', $package_id)->get();

    return response()->json([
        'package' => $package,
        'galleries' => $galleries,
    ]);
}



}
