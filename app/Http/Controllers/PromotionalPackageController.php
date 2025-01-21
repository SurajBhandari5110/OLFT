<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\PromotionalPackage;
use App\Package;
use Exception;

class PromotionalPackageController extends Controller
{
    public function index()
    {
        try {
            $promotionalPackages = PromotionalPackage::all();
            return view('promotional-packages.index', compact('promotionalPackages'));
        } catch (Exception $e) {
            // Handle the exception (e.g., log it, return a custom error response)
            return response()->json(['success' => false, 'message' => 'Failed to fetch promotional packages.']);
        }
    }
    
    // Show the form with destinations dropdown
    public function create(Request $request)
    {
        try {
            // Fetch all countries for the dropdown
            $countries = Package::select('country')->distinct()->get();
            
            // Fetch packages based on selected country
            $packages = collect();
            if ($request->has('country')) {
                $packages = Package::where('country', $request->country)->get();
            }

            return view('promotional-packages.create', compact('countries', 'packages'));
        } catch (Exception $e) {
            // Handle the exception (e.g., log it, return a custom error response)
            return response()->json(['success' => false, 'message' => 'Failed to load countries and packages.']);
        }
    }

    public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'pk_Package_id' => 'required|exists:packages,pk_Package_id',
            'dynamic-url' => 'required|string',
        ]);

        $packageId = $validatedData['pk_Package_id'];
        $dynamicUrl = $validatedData['dynamic-url'];

        // Construct the full promotional URL
        $generatedUrl = "http://13.203.104.207/{$dynamicUrl}";

        // Store the promotional package in the database
        $promotionalPackage = PromotionalPackage::updateOrCreate(
            ['pk_Package_id' => $packageId],
            ['generated_url' => $generatedUrl]
        );

        return redirect()
            ->route('promotional-packages.index')
            ->with('success', 'Promotional package URL generated and stored successfully!');
    } catch (Exception $e) {
        // Handle the exception (e.g., log it, return a custom error response)
        return response()->json(['success' => false, 'message' => 'Failed to store the promotional package.']);
    }
}

    public function getPackagesByDestination(Request $request)
    {
        try {
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
        } catch (Exception $e) {
            // Handle the exception (e.g., log it, return a custom error response)
            return response()->json(['success' => false, 'message' => 'Failed to fetch packages by destination.']);
        }
    }

    // Store the generated URL
    public function storeGeneratedUrl(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'pk_Package_id' => 'required|exists:packages,pk_Package_id',
            ]);

            $packageId = $validatedData['pk_Package_id'];
            $dynamicUrl = $validatedData['dynamic-url'];

            // Construct the full promotional URL
            $generatedUrl = "http://13.203.104.207/{$dynamicUrl}";

            // Create or update the promotional package record
            PromotionalPackage::updateOrCreate(
                ['pk_Package_id' => $packageId],
                ['generated_url' => $generatedUrl]
            );

            return response()->json([
                'success' => true,
                'message' => 'Promotional package URL stored successfully.',
            ]);
        } catch (Exception $e) {
            // Handle the exception (e.g., log it, return a custom error response)
            return response()->json(['success' => false, 'message' => 'Failed to store the promotional URL.']);
        }
    }
     
    public function fetching_Promotional_URL()
    {
        try {
            $promotionalPackages = PromotionalPackage::all();
            //$package = Package::findOrFail($packageId); 
            return response()->json([
                'success' => true,
                'data' =>$promotionalPackages,
                //'data' => $package,

            ]);
        } catch (Exception $e) {
            // Handle the exception (e.g., log it, return a custom error response)
            return response()->json(['success' => false, 'message' => 'Failed to fetch package details.']);
        }
    }
    
    public function destroy($id)
    {
        try {
            // Find the promotional package by ID
            $promotionalPackage = PromotionalPackage::findOrFail($id);

            // Delete the promotional package
            $promotionalPackage->delete();

            // Redirect back to the package list with a success message
            $promotionalPackages = PromotionalPackage::all();
            return view('promotional-packages.index', compact('promotionalPackages'))->with('success', 'Package URL deleted successfully!');
        } catch (Exception $e) {
            // Handle the exception (e.g., log it, return a custom error response)
            return response()->json(['success' => false, 'message' => 'Failed to delete promotional package.']);
        }
    }
}
