<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TourGuideController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InclusionController;
use App\Http\Controllers\ItinerariesController;
use App\Http\Controllers\GalleryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [TourController::class, 'index']);


Route::get('footer', [ContactController::class, 'showFooter'])->name('footer.show');




Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


Route::get('package/{id}', [PackageController::class, 'show'])->name('package.show');



Route::get('packages', [PackageController::class, 'index'])->name('packages.index');  // List all packages
Route::get('packages/create', [PackageController::class, 'create'])->name('packages.create');  // Show form to create a new package
Route::post('packages', [PackageController::class, 'store'])->name('packages.store');  // Store a new package
Route::get('packages/{id}/edit', [PackageController::class, 'edit'])->name('packages.edit');  // Show form to edit a package
Route::put('packages/{id}', [PackageController::class, 'update'])->name('packages.update');  // Update an existing package
Route::delete('packages/{id}', [PackageController::class, 'destroy'])->name('packages.destroy');  // Delete a package




Route::get('/tourguides', [TourGuideController::class,'index']);
Route::get('tourguides', [TourGuideController::class, 'index'])->name('tourguides.index');
// Route to view the form for creating a new tour guide
Route::get('tourguides/create', [TourGuideController::class, 'create'])->name('tourguides.create');

// Route to store the newly created tour guide
Route::post('tourguides', [TourGuideController::class, 'store'])->name('tourguides.store');
// New routes for edit, update, and delete
Route::get('tourguides/{id}/edit', [TourGuideController::class, 'edit'])->name('tourguides.edit');
Route::put('tourguides/{id}', [TourGuideController::class, 'update'])->name('tourguides.update');
Route::delete('tourguides/{id}', [TourGuideController::class, 'destroy'])->name('tourguides.destroy');

//show data of all tourguids
Route::get('tourguide_data', [TourGuideController::class, 'show'])->name('tourguides.show');



//itineries 
// Add these routes to handle itinerary creation and storing

Route::post('/itineraries/save', [ItinerariesController::class, 'store'])->name('save.itinerary');

Route::get('/create-itinerary/{package_id}', [ItinerariesController::class, 'create'])->name('create.itinerary');

Route::resource('itineraries', ItinerariesController::class);

//Gallaries
Route::get('/galleries/create/{package}', [GalleryController::class, 'create'])->name('galleries.create');
Route::post('/galleries/store', [GalleryController::class, 'store'])->name('galleries.store');
Route::get('/galleries', [GalleryController::class, 'index'])->name('galleries.index');
Route::get('packages/{pk_Package_id}/gallery/create', [GalleryController::class, 'create'])->name('galleries.create');

//include and exclude api


// Routes for Inclusion


Route::prefix('inclusions')->group(function () {
    Route::get('/', [InclusionController::class, 'index'])->name('inclusions.index');
    Route::get('/create/{packageId}', [InclusionController::class, 'create'])->name('inclusions.create');
    Route::post('/store', [InclusionController::class, 'store'])->name('inclusions.store');
    Route::get('/{id}/edit', [InclusionController::class, 'edit'])->name('inclusions.edit');
    Route::put('/{id}', [InclusionController::class, 'update'])->name('inclusions.update');
    Route::delete('/{id}', [InclusionController::class, 'destroy'])->name('inclusions.destroy');
});



