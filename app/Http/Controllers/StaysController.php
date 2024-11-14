<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stays;
use Illuminate\Support\Facades\Storage;

class StaysController extends Controller
{
    // Show all stays in Voyager view
    public function index()
    {
        $stays = Stays::all();
        return view('stays.index', compact('stays'));
    }

    // Show form to create a new stay
    public function create()
    {
        return view('stays.create');
    }

    // Store new stay and upload image to S3
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'country' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle the image upload to S3
        $file = $request->file('image');
        $requestData = $request->all();
        $sanitizedTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->input('name'));
        // $sanitizedTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', strtolower($request->input('title')));
        $fileName = $sanitizedTitle . '.' . $file->getClientOriginalExtension();


        // $path = $request->file('image')->storeAs('packages', $fileName, 'public');
        // $requestData["image"] = 'storage/'.$path;
        $path = Storage::disk('s3')->putFileAs('hotels', $file, $fileName);
        $requestData['image'] = Storage::disk('s3')->url($path);

        // Set the file's full URL in the request data
        

        // Create new stay record
        Stays::create($requestData);

        return redirect()->route('stays.index')->with('success', 'Stay created successfully');
    }
    public function edit($id)
    {
        $stay = Stays::findOrFail($id);
        return view('stays.edit', compact('stay'));
    }

    // Update the specified stay and handle image update
    public function update(Request $request, $id)
    {
        $stay = Stays::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'country' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $requestData = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image from S3 if it exists
            if ($stay->image) {
                $oldImagePath = parse_url($stay->image, PHP_URL_PATH);
                Storage::disk('s3')->delete($oldImagePath);
            }

            // Upload new image to S3
            $file = $request->file('image');
            $sanitizedTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->input('name'));
            $fileName = $sanitizedTitle . '.' . $file->getClientOriginalExtension();

            $path = Storage::disk('s3')->putFileAs('hotels', $file, $fileName);
            $requestData['image'] = Storage::disk('s3')->url($path);
        }

        // Update the stay record with new data
        $stay->update($requestData);

        return redirect()->route('stays.index')->with('success', 'Stay updated successfully');
    }
    public function destroy($id)
{
    $stay = Stays::findOrFail($id);

    // Delete the image from S3 if it exists
    if ($stay->image) {
        $filePath = str_replace(Storage::disk('s3')->url('/'), '', $stay->image);
        Storage::disk('s3')->delete($filePath);
    }

    $stay->delete();

    return redirect()->route('stays.index')->with('success', 'Stay deleted successfully');
}

}