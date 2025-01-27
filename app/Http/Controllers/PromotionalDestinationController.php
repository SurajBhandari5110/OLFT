<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PromotionalDestination;
use App\Destination;
use Exception;

class PromotionalDestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::all();

        try {
            $promotionalDestinations = PromotionalDestination::all();
            return view('promotional-destinations.index', compact('destinations','promotionalDestinations'));
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to fetch promotional destinations.']);
        }
    }

    public function create(Request $request)
    {
        try {
            $destinations = Destination::all();
            return view('promotional-destinations.create', compact('destinations'));
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to load destinations.']);
        }
    }

    public function store(Request $request)
    {
        $destinations = Destination::all();
        
            $validatedData = $request->validate([
                'destination_id' => 'required|exists:destinations,id',
                'dynamic-url' => 'required|string',
            ]);

            $destinationId = $validatedData['destination_id'];
            $dynamicUrl = $validatedData['dynamic-url'];
            $generatedUrl = "http://13.203.104.207/destination/{$dynamicUrl}";

            // Store the promotional destination in the database
            PromotionalDestination::updateOrCreate(
                ['destination_id' => $destinationId],
                ['generated_url' => $generatedUrl]
            );

            
            

            try {
                $promotionalDestinations = PromotionalDestination::all();
                return view('promotional-destinations.index', compact('destinations','promotionalDestinations'))->with('success', 'Promotional destination URL generated and stored successfully!');
            } catch (Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to fetch promotional destinations.']);
            }
        
       
    }

    public function destroy($id)
    {
        $destinations = Destination::all();
        try {
            $promotionalDestination = PromotionalDestination::findOrFail($id);
            $promotionalDestination->delete();
            $promotionalDestinations = PromotionalDestination::all();

            return view('promotional-destinations.index', compact('destinations','promotionalDestinations'))->with('success', 'Promotional destination deleted successfully!');
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete promotional destination.']);
        }
    }

    public function fetchGeneratedUrl()
    {
        
        try {
            $promotionalDestinations = PromotionalDestination::all();
            

            if (!$promotionalDestinations) {
                return response()->json(['success' => false, 'message' => 'No promotional URL found for this destination.'], 404);
            }

            return response()->json(['success' => true, 'data' => $promotionalDestinations]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to fetch promotional URL.']);
        }
    }
}
