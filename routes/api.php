<?php
use App\Package;
use App\TourGuide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TourGuideController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InclusionController;
use App\Http\Controllers\ItinerariesController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ClientQueryController;


use App\Http\Controllers\PackageStayController;

use App\Http\Controllers\StaysController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\BlogController;

use App\Http\Controllers\PromotionalPackageController;



// Optional: Test route to check API connectivity
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



//packages API's
Route::prefix('packages')->group(function () {

    Route::get('/', [TourController::class, 'index']);
    Route::get('/{id}', [PackageController::class, 'show'])->name('package.show');
    Route::get('/country/{country}', action: [PackageController::class, 'getPackagesByCountry']);
});
//fetching blogs
Route::prefix('blogs')->group(function () {
    Route::get('/', [BlogController::class, 'fetchBlog']); // Display all blogs
    Route::get('/{id}', [BlogController::class, 'show'])->name('blogs.show');
});

//Fetching all packages
Route::get('/', [TourController::class, 'index']);

//client form
Route::post('client-queries/store', [ClientQueryController::class, 'store'])->name('client-queries.store');
//footer
Route::get('footer', [ContactController::class, 'showFooter'])->name('footer.show');
//tourguides
Route::get('tourguide-data', [TourGuideController::class, 'show'])->name('tourguides.show');
//galleries
Route::get('galleries/{packageId}', [GalleryController::class, 'fetchByPackageId']);
//destinations
Route::get('/destinations/show', [DestinationController::class, 'show']);
Route::get('destinations/country/{country}', [DestinationController::class, 'getDestinationsByCountry'])->name('destinations.byCountry');


//fetching by categry and tags
Route::get('/category/{name}/', [CategoryController::class, 'fetchPackagesByCategory'])->name('categories.fetchBySlug');
Route::get('/tag/{tag}/', [TagController::class, 'fetchPackagesByTag'])->name('tags.fetchBySlug');
//itineraries
Route::get('itineraries/{packageId}', [ItinerariesController::class, 'fetchItineraries']);
//fetching promotional packages:
Route::get('/promotional-packages/{packageId}', [PromotionalPackageController::class, 'fetching_Promotional_URL']);