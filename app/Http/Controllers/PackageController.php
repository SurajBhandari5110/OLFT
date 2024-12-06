<?php
namespace App\Http\Controllers;
use App\Country;
use App\Itineraries;
use App\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PackageController extends Controller
{
    // Display a list of packages
    public function index()
{
    // $packages = Package::with('country')->get();
    $packages = Package::all();
    
    

    foreach ($packages as $package) {
        // Check if there are itineraries for each package based on pk_Package_id
        $package->hasItineraries = Itineraries::where('pk_Package_id', $package->pk_Package_id)->exists();
    }
    

    return view('packages.index', compact('packages'));
}
public function create()
{
    $countries =Country::all(); // Fetch all countries
    return view('packages.create', compact('countries'));
}

public function store(Request $request)
{
    // Validate incoming data
    $request->validate([
        'title' => 'required|string|max:255',
        'about' => 'required|string',
        'country' => 'required|exists:countries,id',
        'state' => 'required|string',
        'duration' => 'required|integer',
        'tour_type' => 'required|string',
        'group_size' => 'required|integer',
        'tour_guide' => 'required|string',
        'coordinates' => 'required|string',
        'travel_with_bus' => 'required|string',
        'image' => 'required|image|max:2048', // Adjust max size if needed
    ]);

    $requestData = $request->except('image'); // Get all data except image
    
    // Process and store the image if uploaded
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $sanitizedTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->input('title'));
        $fileName = $sanitizedTitle . '.' . $file->getClientOriginalExtension();

        // Store image in S3 and get the URL
        $path = Storage::disk('s3')->putFileAs('packages', $file, $fileName);
        $requestData['image'] = Storage::disk('s3')->url($path);
    }

   

    // Redirect with success message
    $package = Package::create($requestData);  // This should return a Package instance

// Verify the instance creation
if (!$package) {
    return redirect()->route('packages.index')->with('error', 'Failed to create the package.');
}

// Redirect to the edit route for the newly created package
return redirect()->route('packages.edit', $package->pk_Package_id)
                 ->with('success', 'Package created successfully! You can now edit the details.');
}


    public function show($id)
    {
        $package = Package::with('inclusions.include')->findOrFail($id);

        // if ($package) {
        //     return view('packages.show', compact('package'));
        // } else {
        //     return redirect()->route('packages.index')->with('error', 'Package not found');
        // }
        //to show include and exclude:
        if ($package) {
            return view('packages.show', compact('package'));
            } else {
                return redirect()->route('packages.index')->with('error', 'Package not found');
            }
        
        
    }
    public function edit($id)
    {
        $package = Package::findOrFail($id);
        $countries =Country::all(); // Fetch all countries
        return view('packages.edit', compact('package','countries'));
 
    }
    public function update(Request $request, $id)
    {
        $package = Package::find($id);

        if ($package) {
            $requestData = $request->all();

            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                // Delete the old image from storage (S3 in this case)
                if ($package->image) {
                    Storage::disk('s3')->delete(parse_url($package->image, PHP_URL_PATH));
                }

                // Store the new image
                $file = $request->file('image');
                $sanitizedTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $id);
                $fileName = $sanitizedTitle . '.' . $file->getClientOriginalExtension();
                $path = Storage::disk('s3')->putFileAs('packages', $file, $fileName);

                // Save the new image URL in the request data
                $requestData['image'] = Storage::disk('s3')->url($path);
            }

            // Update the package details
            $package->update($requestData);

            return redirect()->route('packages.index')->with('success', 'Package updated successfully!');
        } else {
            return redirect()->route('packages.index')->with('error', 'Package not found');
        }
    }


    // Delete a package
    public function destroy($id)
    {
        $package = Package::find($id);

        if ($package) {
            // Delete the image from storage
            if ($package->image) {
                Storage::disk('s3')->delete(parse_url($package->image, PHP_URL_PATH));
            }

            $package->delete();

            return redirect()->route('packages.index')->with('success', 'Package deleted successfully!');
        } else {
            return redirect()->route('packages.index')->with('error', 'Package not found');
        }
    }
    public function uploadGalleryImage(Request $request)
{
    $request->validate([
        'package_id' => 'required|exists:packages,pk_Package_id',
        'gallery_image' => 'required|image|max:2048', // Adjust max size as needed
    ]);

    $package = Package::find($request->package_id);

    if ($package) {
        // Store the image in S3
        $file = $request->file('gallery_image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = Storage::disk('s3')->putFileAs('packages/gallery', $file, $fileName);
        $imageUrl = Storage::disk('s3')->url($path);

        // Save image to the gallery associated with the package
        $package->galleries()->create(['image_url' => $imageUrl]);

        return back()->with('success', 'Image uploaded successfully!');
    }

    return back()->with('error', 'Failed to upload image.');
}
/**
 * Fetch packages by country.
 *
 * @param  int  $countryId
 * @return \Illuminate\Http\JsonResponse
 */
public function getPackagesByCountry($country)
{
    // Fetch packages belonging to the specified country
    $packages = Package::where('country', $country)->get();

    // Check if any packages are found
    if ($packages->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No packages found for the specified country.',
        ], 404);
    }

    // Return the packages as JSON
    return response()->json([
        'success' => true,
        'data' => $packages,
    ]);
}




}

