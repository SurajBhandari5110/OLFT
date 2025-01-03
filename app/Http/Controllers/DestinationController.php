<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Destination;
use App\Country;

class DestinationController extends Controller
{
    
     
    public function index()
    {
        $destinations = Destination::all();
        return view('destinations.index', compact('destinations'));
    }

   
    public function create()
    {
        $countries =Country::all();
        return view('destinations.create',compact('countries'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'country' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about' => 'nullable|string',
            'attraction' => 'nullable|string',
            'coordinates' => 'nullable|string',
        ]);

        $requestData = $request->except('image'); // Get all data except the image

        // Process and store the image if uploaded
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            // Store the image in S3 and get the URL
            $path = Storage::disk('s3')->putFileAs('destination', $file, $fileName);
            $requestData['image'] = Storage::disk('s3')->url($path);
        }

        Destination::create($requestData);
        $destinations = Destination::all();

        

        
        return view('destinations.index', compact('destinations'))->with('success', 'Destination created successfully!');
    }
    public function destroy(Destination $destination)
    {
        // Delete the image from S3 if it exists
        if ($destination->image) {
            $oldPath = str_replace(Storage::disk('s3')->url(''), '', $destination->image);
            Storage::disk('s3')->delete($oldPath);
        }

        $destination->delete();

        return redirect()->route('destinations.index')->with('success', 'Destination deleted successfully!');
    }
    public function edit(Destination $destination)
    {
        $countries = Country::all();
        return view('destinations.edit', compact('destination', 'countries'));
    }
    public function update(Request $request, Destination $destination)
    {
        $request->validate([
            'country' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about' => 'nullable|string',
            'attraction' => 'nullable|string',
            'coordinates' => 'nullable|string',
        ]);

        $requestData = $request->except('image'); // Get all data except the image

        // Process and update the image if uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($destination->image) {
                $oldPath = str_replace(Storage::disk('s3')->url(''), '', $destination->image);
                Storage::disk('s3')->delete($oldPath);
            }

            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            // Store the new image in S3 and get the URL
            $path = Storage::disk('s3')->putFileAs('destination', $file, $fileName);
            $requestData['image'] = Storage::disk('s3')->url($path);
        }

        $destination->update($requestData);

        return redirect()->route('destinations.index')->with('success', 'Destination updated successfully!');
    }
    public function getDestinationsByCountry($country)
{
    // Fetch destinations matching the country
    $destinations = Destination::where('country', $country)->get();

    // Return the destinations as JSON response
    return response()->json([
        'success' => true,
        'data' => $destinations
    ]);
}
public function show()
    {
        $destinations = Destination::all();
        //return view('destinations.index', compact('destinations'));
        return response()->json(['success' => true,'data' => $destinations],200);
}
}

 