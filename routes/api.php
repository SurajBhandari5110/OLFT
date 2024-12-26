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


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route to fetch packages data
Route::get('/packages', [TourController::class, 'index']);

// Optional: Test route to check API connectivity
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('client_queries/store', [ClientQueryController::class, 'store'])->name('client_queries.store');
//Public Routes
Route::get('/', [TourController::class, 'index']);
Route::get('footer', [ContactController::class, 'showFooter'])->name('footer.show');
Route::get('package/{id}', [PackageController::class, 'show'])->name('package.show');
Route::get('tourguide_data', [TourGuideController::class, 'show'])->name('tourguides.show');
Route::get('galleries/package/{package_id}', [GalleryController::class, 'fetchByPackageId']);
Route::get('/destinations/country/{country}', [DestinationController::class, 'getDestinationsByCountry'])->name('destinations.byCountry');
Route::get('/packages/country/{country}', [PackageController::class, 'getPackagesByCountry']);

//fetching by categry and tags
Route::get('/category/{name}/', [CategoryController::class, 'fetchPackagesByCategory'])->name('categories.fetchBySlug');
Route::get('/tag/{tag}/', [TagController::class, 'fetchPackagesByTag'])->name('tags.fetchBySlug');

//fetching blogs
Route::get('/blogs_details', [BlogController::class, 'fetchBlog']); // Display all blogs
Route::get('/blogs_details/{id}', [BlogController::class, 'show'])->name('blogs.show');