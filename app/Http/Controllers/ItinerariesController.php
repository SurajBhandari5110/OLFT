<?php
namespace App\Http\Controllers;

use App\Package;
use App\Itineraries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItinerariesController extends Controller
{
    public function index()
{
    // Fetch all itineraries along with related package information
    $itineraries = Itineraries::with('package')->get();

    // Return the view with itineraries data
    return view('itineraries.index', compact('itineraries'));
}
    public function create($id)
    {
        // Retrieve the current package and its duration
        $package = Package::findOrFail($id);
        $duration = $package->duration;

        // Find packages with the same duration that have existing itineraries
        $matchingPackages = Package::where('duration', $duration)
            ->whereHas('itineraries')
            ->where('pk_Package_id', '!=', $id) // Exclude the current package
            ->get();

        return view('itineraries.create', compact('package', 'duration', 'matchingPackages'));
    }
    public function store(Request $request)
{
    // Check if the user has selected a package to copy itineraries from
    if ($request->has('copy_from_package_id') && $request->copy_from_package_id) {
        $copyFromPackageId = $request->copy_from_package_id;

        // Fetch itineraries from the selected package
        $itinerariesToCopy = Itineraries::where('pk_Package_id', $copyFromPackageId)->get();

        // Loop through the itineraries to copy
        foreach ($itinerariesToCopy as $itineraryData) {
            $itinerary = new Itineraries();

            // Set the new package ID
            $itinerary->pk_Package_id = $request->pk_Package_id; // New package ID

            // Copy existing data
            $itinerary->days = $itineraryData->days;
            $itinerary->title = $itineraryData->title;
            $itinerary->description = $itineraryData->description;

            // Copy the image URL
            $itinerary->image = $itineraryData->image; // Store the image URL directly

            $itinerary->save();
        }

        return redirect()->route('itineraries.index', $request->pk_Package_id)->with('success', 'Itineraries copied successfully.');
    }

    // If no package is selected, handle user input as usual
    foreach ($request->itineraries as $day => $itineraryData) {
        $itinerary = new Itineraries();
        $itinerary->pk_Package_id = $request->pk_Package_id; // Set the package ID
        $itinerary->days = $itineraryData['days'];
        $itinerary->title = $itineraryData['title'];
        $itinerary->description = $itineraryData['description'];

        // Handle image upload if provided
        if (isset($itineraryData['image'])) {
            $itinerary->image = $itineraryData['image']->store('images', 'public'); // Save the image and store the path
        }

        $itinerary->save();
    }

    return redirect()->route('itineraries.index', $request->pk_Package_id)->with('success', 'Itineraries created successfully.');
}




    public function destroyByPackage($id)
{
    // Delete all itineraries where the package_id matches the provided package ID
    $deletedRows = Itineraries::where('pk_Package_id', $id)->delete();

    if ($deletedRows) {
        return redirect()->back()->with('success', 'All itineraries deleted successfully.');
    }

    return redirect()->back()->with('error', 'No itineraries found for this package.');
}



    public function fetchItineraries($id)
    {
        // Fetch itineraries for the selected package
        $itineraries = Itineraries::where('pk_Package_id', $id)->get();

        return response()->json(['itineraries' => $itineraries]);
    }
    
    public function destroy($id)
    {
        // Delete all itineraries for a specific package
        $itineraries = Itineraries::where('pk_Package_id', $id);

        if ($itineraries->exists()) {
            $itineraries->delete();
            return redirect()->back()->with('success', 'All itineraries deleted successfully.');
        }

        return redirect()->back()->with('error', 'No itineraries found for this package.');
    }
    
}
