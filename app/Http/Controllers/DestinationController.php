<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Destination;
use App\Country;

class DestinationController extends Controller
{
    
    /**
     * Display a listing of the destinations for Voyager with a "Create New" button.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $destinations = Destination::all();
        return view('destinations.index', compact('destinations'));
    }

    /**
     * Show the form for creating a new destination.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $countries =Country::all();
        return view('destinations.create',compact('countries'));
    }

    /**
     * Store a newly created destination in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
}

 