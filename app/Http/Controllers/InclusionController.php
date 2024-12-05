<?php

namespace App\Http\Controllers;

use App\Inclusion;
use App\Package;
use Illuminate\Http\Request;
use App\Includes;

class InclusionController extends Controller
{
    public function index()
    {
        $inclusions = Inclusion::with(['package', 'include'])->get();
        return view('inclusions.index', compact('inclusions'));
    }

    public function create($packageId)
{
    $includes = Includes::all(); // Get all benefits from the `includes` table
    return view('inclusions.create', compact('packageId', 'includes'));
}
public function store(Request $request)
{
    $packageId = $request->input('pk_Package_id');

    // Loop through all includes to set isActive values
    foreach ($request->input('inclusions') as $inclusionData) {
        $isActive = isset($inclusionData['isActive']) && $inclusionData['isActive'] == '1' ? 1 : 0;

        Inclusion::updateOrCreate(
            [
                'pk_Package_id' => $packageId,
                'include_id' => $inclusionData['include_id'],
            ],
            [
                'isActive' => $isActive,
            ]
        );
    }

    return redirect()->route('packages.index')->with('success', 'Inclusions updated successfully.');
}



    public function update(Request $request, $id)
    {
        $inclusion = Inclusion::findOrFail($id);
        $inclusion->isActive = $request->input('isActive', 0);
        $inclusion->save();

        return redirect()->route('inclusions.index')->with('success', 'Inclusion updated successfully.');
    }

    public function destroy($id)
    {
        $inclusion = Inclusion::findOrFail($id);
        $inclusion->delete();

        return redirect()->route('inclusions.index')->with('success', 'Inclusion deleted successfully.');
    }
    
    // Display the manage inclusions form for a specific package
    public function manage(Request $request, $packageId)
    {
        // Fetch all available includes
        $includes = Includes::all();

        // Fetch existing inclusions for the package
        $existingInclusions = Inclusion::where('pk_Package_id', $packageId)->pluck('isActive', 'include_id');

        // If POST request, handle form submission
        if ($request->isMethod('post')) {
            // Loop through the form data and update inclusions
            foreach ($request->input('inclusions') as $inclusionData) {
                $isActive = isset($inclusionData['isActive']) && $inclusionData['isActive'] == '1' ? 1 : 0;

                Inclusion::updateOrCreate(
                    [
                        'pk_Package_id' => $packageId,
                        'include_id' => $inclusionData['include_id'],
                    ],
                    [
                        'isActive' => $isActive,
                    ]
                );
            }

            
            return redirect()->route('packages.edit', $packageId)
                 ->with('success', 'Inclusions updated successfully.');
        }

        // Show the manage inclusions view with existing data
        return view('inclusions.manage', compact('packageId', 'includes', 'existingInclusions'));
    }
}

