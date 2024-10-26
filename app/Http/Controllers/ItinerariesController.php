<?php
namespace App\Http\Controllers;

use App\Package;
use App\Itineraries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItinerariesController extends Controller
{
    //index
    public function index()
{
    // Fetch all itineraries along with related package information
    $itineraries = Itineraries::with('package')->get();

    // Return the view with itineraries data
    return view('itineraries.index', compact('itineraries'));
}

    // Show the form to create itineraries for a package
    public function create($package_id)
    {
        // Find the package by its ID
        $package = Package::findOrFail($package_id);

        // Get the duration (number of days)
        $duration = $package->duration;

        // Pass the package and duration to the view
        return view('itineraries.create', compact('package', 'duration'));
    }

    // Store the submitted itineraries
    public function store(Request $request)
{
    // Validate incoming data
    $request->validate([
        'package_id' => 'required|exists:packages,pk_Package_id',
        'itineraries.*.days' => 'required|integer',
        'itineraries.*.title' => 'required|string|max:255',
        'itineraries.*.description' => 'required|string',
        'itineraries.*.image' => 'nullable|image|max:2048', // Validate images
    ]);

    // Loop through the itineraries array and store each one
    foreach ($request->itineraries as $itineraryData) {
        $itinerary = new Itineraries();
        $itinerary->pk_Package_id = $request->package_id;
        $itinerary->days = $itineraryData['days'];
        $itinerary->title = $itineraryData['title'];
        $itinerary->description = $itineraryData['description'];

        // Handle file upload for the image
        if (isset($itineraryData['image'])) {
            $file = $itineraryData['image'];
            $sanitizedTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $itineraryData['title']);
            $fileName = $sanitizedTitle . '.' . $file->getClientOriginalExtension();

            // Store the image on S3 and get the URL
            $path = Storage::disk('s3')->putFileAs('itineraries', $file, $fileName);
            $itinerary->image = Storage::disk('s3')->url($path);
        }

        $itinerary->save(); // Save the itinerary to the database
    }

    return redirect()->route('itineraries.index')->with('success', 'Itineraries created successfully!');
}

    
}
