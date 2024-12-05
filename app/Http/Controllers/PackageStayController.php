<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Package;
use App\Stays;
use App\PackageStay;

class PackageStayController extends Controller
{
    // Show all stays in Voyager view
    public function index()
    {
        $stays = PackageStay::all();
        return view('package_stay.index', compact('stays'));
    }

    public function create($pk_Package_id)
{
    // Retrieve the package details
    $package = Package::findOrFail($pk_Package_id);

    // Fetch already added hotels for this package with their details
    $existingHotels = PackageStay::where('pk_Package_id', $pk_Package_id)
                                  ->join('stays', 'package_stays.pk_hotel_id', '=', 'stays.pk_hotel_id')
                                  ->select('stays.pk_hotel_id', 'stays.name')
                                  ->get();

    // Get IDs of already added hotels to exclude from the dropdown
    $addedHotelIds = $existingHotels->pluck('pk_hotel_id');

    // Fetch hotels with either the same country or state as the package that are not already added
    $hotels = Stays::where('country', $package->country)
                   ->orWhere('state', $package->state)
                   ->whereNotIn('pk_hotel_id', $addedHotelIds)
                   ->select('pk_hotel_id', 'name')
                   ->get();

    return view('package_stays.create', compact('package', 'hotels', 'existingHotels'));
}



    public function store(Request $request, $pk_Package_id)
    {
        // Validate that pk_hotel_id exists in stays table
        $request->validate([
            'pk_hotel_id' => 'required|exists:stays,pk_hotel_id'
        ]);

        // Create a new entry in the package_stays table
        $packageStay = new PackageStay();
        $packageStay->pk_Package_id = $pk_Package_id;
        $packageStay->pk_hotel_id = $request->input('pk_hotel_id');
        $packageStay->save();

        // return redirect()->route('packages.index')->with('success', 'Hotel added to the package successfully.');
        return redirect()->route('packages.edit', $pk_Package_id)
                 ->with('success', 'Package created successfully! You can now edit the details.');
    }
}
