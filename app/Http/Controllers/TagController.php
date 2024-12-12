<?php

namespace App\Http\Controllers;

use App\Tag;
use App\TourTag;
use Illuminate\Http\Request;



class TagController extends Controller
{
    // Method to display tags associated with a package
    public function manage($pk_Package_id)
    {
        $tags = Tag::all(); // Fetch all available tags
        $selectedTags = TourTag::where('pk_Package_id', $pk_Package_id)->pluck('tag')->toArray(); // Fetch tags for the package

        return view('tags.manage', compact('tags', 'selectedTags', 'pk_Package_id'));
    }

    // Other methods like add/remove
    public function add(Request $request)
    {
        $request->validate([
            'pk_Package_id' => 'required|exists:packages,pk_Package_id',
            'tag' => 'required|exists:tags,tag',
        ]);

        TourTag::create([
            'pk_Package_id' => $request->pk_Package_id,
            'tag' => $request->tag,
        ]);

        return redirect()->route('tags.manage', $request->pk_Package_id)->with('success', 'Tag added successfully.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'pk_Package_id' => 'required|exists:packages,pk_Package_id',
            'tag' => 'required|exists:tags,tag',
        ]);

        TourTag::where('pk_Package_id', $request->pk_Package_id)
            ->where('tag', $request->tag)
            ->delete();

        return redirect()->route('tags.manage', $request->pk_Package_id)->with('success', 'Tag removed successfully.');
    }
    public function fetchPackagesByTag($tagSlug)
{
    // Find the tag by its slug or name
    $tag = Tag::where('tag', $tagSlug)->first();

    if (!$tag) {
        return abort(404, 'Tag not found.');
    }

    // Fetch packages linked to the tag
    $packages = TourTag::where('tag', $tag->tag)
        ->join('packages', 'tour_tags.pk_Package_id', '=', 'packages.pk_Package_id')
        ->select('packages.*') // Select package details
        ->get();

        return response()->json([
            'success' => true,
            'data' => $packages,
        ]);
}


}
