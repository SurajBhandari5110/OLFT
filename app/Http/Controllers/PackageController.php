<?php
namespace App\Http\Controllers;

use App\Itineraries;
use App\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    // Display a list of packages
    public function index()
{
    $packages = Package::all();

    foreach ($packages as $package) {
        // Check if there are itineraries for each package based on pk_Package_id
        $package->hasItineraries = Itineraries::where('pk_Package_id', $package->pk_Package_id)->exists();
    }
    

    return view('packages.index', compact('packages'));
}
    


    // Show the form for creating a new package
    public function create()
    {
        return view('packages.create');
    }

    public function store(Request $request)
    {
        $file = $request->file('image');
        $requestData = $request->all();
        $sanitizedTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->input('title'));
        // $sanitizedTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', strtolower($request->input('title')));
        $fileName = $sanitizedTitle . '.' . $file->getClientOriginalExtension();


        // $path = $request->file('image')->storeAs('packages', $fileName, 'public');
        // $requestData["image"] = 'storage/'.$path;
        $path = Storage::disk('s3')->putFileAs('packages', $file, $fileName);

        // Set the file's full URL in the request data
        $requestData['image'] = Storage::disk('s3')->url($path);

        // $img = env . 'packages/' . $var->imageName



        Package::create($requestData);


        return redirect()->route('packages.index')->with('success', 'Package created successfully!');
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
        return view('packages.edit', compact('package'));
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
                $sanitizedTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->input('title'));
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



}

