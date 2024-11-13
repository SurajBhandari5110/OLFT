<?php

namespace App\Http\Controllers;

use App\TourGuide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class TourGuideController extends Controller
{
    public function index()
    {
        $tourguides = TourGuide::all();
        return view('tourguides.index', ['tourguides' => $tourguides]);
    }
    // Fetch the tour guides and pass them to the view
    public function showView()
    {
        // Fetch all tour guides from the database
        $tourguides = TourGuide::all();
        
        // Pass the tour guide data to the Blade view
        return view('tourguides.index', ['tourguides' => $tourguides]);
    }
    public function create()
    {
        return view('tourguides.create');
    }
    public function store(Request $request)
    {
        $file = $request->file('image');
        $requestData = $request->all();
        $sanitizedTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->input('captain'));
        $fileName = $sanitizedTitle . '.' . $file->getClientOriginalExtension();
        
        
        // $path = $request->file('image')->storeAs('packages', $fileName, 'public');
        // $requestData["image"] = 'storage/'.$path;
        $path = Storage::disk('s3')->putFileAs('tour_guides', $file, $fileName);
    
            // Set the file's full URL in the request data
        $requestData['image'] = Storage::disk('s3')->url($path);
    
        // $img = env . 'packages/' . $var->imageName
        
            
        
        TourGuide::create($requestData);
        
    
        return redirect()->route('tourguides.index')->with('success', 'Package created successfully!');
    }
    public function edit($id)
    {
        $tourguide = TourGuide::findOrFail($id);
        return view('tourguides.edit', compact('tourguide'));
    }
   
public function update(Request $request, $id)
{
    $tourguide = TourGuide::findOrFail($id);

    // Validate request data
    $request->validate([
        'captain' => 'required|string|max:255',
        'phn_number' => 'required|string|max:20',
        'insta' => 'nullable|url',
        'image' => 'nullable|image|max:2048'
    ]);

    // Handle image cropping and upload to S3
    if ($request->hasFile('image')) {
        // Delete old image from S3
        if ($tourguide->image) {
            Storage::disk('s3')->delete(parse_url($tourguide->image));
        }

        // Upload new image to S3
        $image = $request->file('image');
        $sanitizedTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->input('captain'));
        // $sanitizedTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', strtolower($request->input('title')));
        $filename = $sanitizedTitle . '.' . $image->getClientOriginalExtension();

        // Store new image in S3 and get URL
        $path = Storage::disk('s3')->putFileAs('tour_guides', $image, $filename);
        $imageUrl = Storage::disk('s3')->url($path);


        // Update the tour guide's image URL in the database
        $tourguide->image = $imageUrl;
    }

    // Update other fields
    $tourguide->update([
        'captain' => $request->input('captain'),
        'phn_number' => $request->input('phn_number'),
        'insta' => $request->input('insta'),
    ]);

    return redirect()->route('tourguides.index')->with('success', 'Tour Guide updated successfully!');
}


    // Delete an existing tour guide
    public function destroy($id)
    {
        $tourguide = TourGuide::findOrFail($id);
        $tourguide->delete();
        return redirect()->route('tourguides.index')->with('success', 'Tour Guide deleted successfully!');
    }
    //show the data of all the tourguids
    public function show()
{
    $tourguides = TourGuide::all();
    return view('tourguides.cards', compact('tourguides'));
}
}
