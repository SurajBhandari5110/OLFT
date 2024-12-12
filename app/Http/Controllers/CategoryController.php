<?php

namespace App\Http\Controllers;

use App\Category;
use App\TourCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function manage($pk_Package_id)
{
    $categories = Category::all();
    $selectedCategories = TourCategory::where('pk_Package_id', $pk_Package_id)->pluck('name')->toArray();
    
    return view('categories.manage', compact('categories', 'selectedCategories', 'pk_Package_id'));
}


    public function add(Request $request)
    {
        $request->validate([
            'pk_Package_id' => 'required|exists:packages,pk_Package_id',
            'name' => 'required|exists:categories,name',
        ]);

        TourCategory::create([
            'pk_Package_id' => $request->pk_Package_id,
            'name' => $request->name,
        ]);

        return redirect()->route('categories.manage', $request->pk_Package_id)->with('success', 'Category added successfully.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'pk_Package_id' => 'required|exists:packages,pk_Package_id',
            'name' => 'required|exists:categories,name',
        ]);

        TourCategory::where('pk_Package_id', $request->pk_Package_id)
            ->where('name', $request->name)
            ->delete();

        return redirect()->route('categories.manage', $request->pk_Package_id)->with('success', 'Category removed successfully.');
    }
    public function fetchPackagesByCategory($categorySlug)
{
    // Find the category by its slug
    $category = Category::where('name', $categorySlug)->first();

    if (!$category) {
        return abort(404, 'Category not found.');
    }

    // Fetch packages linked to the category
    $packages = TourCategory::where('name', $category->name)
        ->join('packages', 'tour_categories.pk_Package_id', '=', 'packages.pk_Package_id')
        ->select('packages.*') // Select package details
        ->get();
    return response()->json([
            'success' => true,
            'data' => $packages,
        ]);
}


}
