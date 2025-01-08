<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PromotionalPackage;
use App\Package;

class PromotionalPackageController extends Controller
{
    public function index()
    {
        $promotionalPackages = PromotionalPackage::all();
        return view('promotional-packages.index', compact('promotionalPackages'));
    }
    
    // Show the form with destinations dropdown

    public function create(Request $request)
{
    // Fetch all countries for the dropdown
    $countries = Package::select('country')->distinct()->get();

    // Fetch packages based on selected country
    $packages = collect();
    if ($request->has('country')) {
        $packages = Package::where('country', $request->country)->get();
    }

    return view('promotional-packages.create', compact('countries', 'packages'));
}


public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pk_Package_id' => 'required|exists:packages,pk_Package_id',
        ]);

        $packageId = $validatedData['pk_Package_id'];
        $generatedUrl = "http://13.203.104.207/promotional-packages/package{$packageId}";

        // Store the generated URL in the database
        PromotionalPackage::updateOrCreate(
            ['pk_Package_id' => $packageId],
            ['generated_url' => $generatedUrl]
        );
        $promotionalPackages = PromotionalPackage::all();
        return view('promotional-packages.index', compact('promotionalPackages'));

        
    }

    // Fetch packages by selected destination (AJAX call)
    public function getPackagesByDestination(Request $request)
    {
        $country = $request->input('country');

        if (!$country) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a valid destination.',
            ], 400);
        }
        

        $packages = Package::where('country', $country)
            ->get(['pk_Package_id', 'title']);

        if ($packages->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No packages found for the selected destination.',
            ], 404);
        }

        return redirect()->route('promotional-packages.index')->with('success', 'Package URL generated and stored successfully!');
    }

    // Store the generated URL
    public function storeGeneratedUrl(Request $request)
    {
        $validatedData = $request->validate([
            'pk_Package_id' => 'required|exists:packages,pk_Package_id',
        ]);

        $packageId = $validatedData['pk_Package_id'];
        $generatedUrl = "http://13.203.104.207/promotional-packages/package{$packageId}";

        // Create or update the promotional package record
        $promotionalPackage = PromotionalPackage::updateOrCreate(
            ['pk_Package_id' => $packageId],
            ['generated_url' => $generatedUrl]
        );

        return response()->json([
            'success' => true,
            'message' => 'Promotional package URL stored successfully.',
        ]);
    }
     
    public function fetching_Promotional_URL($packageId)
    {
        $package = Package::findOrFail($packageId);
        

        
        return response()->json([
            'success' => true,
            'data' => $package,
        ]);
        
        
    }
    
public function destroy($id)
{
    // Find the promotional package by ID
    $promotionalPackage = PromotionalPackage::findOrFail($id);

    // Delete the promotional package
    $promotionalPackage->delete();

    // Redirect back to the package list with a success message
    $promotionalPackages = PromotionalPackage::all();
        return view('promotional-packages.index', compact('promotionalPackages'))->with('success', 'Package URL generated deleted successfully!');;
   
}


}
