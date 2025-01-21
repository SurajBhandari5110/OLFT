
<?php
use App\Http\Controllers\PackageStayController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TourGuideController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InclusionController;
use App\Http\Controllers\ItinerariesController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\StaysController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ClientQueryController;
use App\Http\Controllers\PromotionalPackageController;
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
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
// Admin Privillages/access by admin only: 
Route::middleware(['admin'])->group(function () {
    Route::prefix('packages')->group(function () {
        Route::get('/', [PackageController::class, 'index'])->name('packages.index');
        // Route::get('packages', [PackageController::class, 'index'])->name('packages.index');  // List all packages
        Route::get('/create', [PackageController::class, 'create'])->name('packages.create');  // Show form to create a new package
        Route::post('/store', [PackageController::class, 'store'])->name('packages.store');  // Store a new package
        Route::get('/{id}/edit', [PackageController::class, 'edit'])->name('packages.edit');  // Show form to edit a package
        Route::put('/{id}', [PackageController::class, 'update'])->name('packages.update');  // Update an existing package
        Route::delete('/{id}', [PackageController::class, 'destroy'])->name('packages.destroy');   // List all packages
        Route::get('/{id}/itineraries', [ItinerariesController::class, 'fetchItineraries']);
        Route::get('/{pk_Package_id}/gallery/create', [GalleryController::class, 'create'])->name('galleries.create');
        Route::get('/create-itinerary/{package_id}', [ItinerariesController::class, 'create'])->name('create.itinerary');
    
    });

    Route::prefix('inclusions')->group(function () {
        Route::get('/', [InclusionController::class, 'index'])->name('inclusions.index');
        Route::get('/create/{packageId}', [InclusionController::class, 'create'])->name('inclusions.create');
        Route::post('/store', [InclusionController::class, 'store'])->name('inclusions.store');
        Route::get('/{id}/edit', [InclusionController::class, 'edit'])->name('inclusions.edit');
        Route::put('/{id}', [InclusionController::class, 'update'])->name('inclusions.update');
        Route::delete('/{id}', [InclusionController::class, 'destroy'])->name('inclusions.destroy');
    });

    Route::prefix('tourguides')->group(function () {

        Route::get('/', [TourGuideController::class, 'index'])->name('tourguides.index');

        // Route to view the form for creating a new tour guide
        Route::get('/create', [TourGuideController::class, 'create'])->name('tourguides.create');

        // Route to store the newly created tour guide
        Route::post('/', [TourGuideController::class, 'store'])->name('tourguides.store');

        // New routes for edit, update, and delete
        Route::get('/{id}/edit', [TourGuideController::class, 'edit'])->name('tourguides.edit');
        Route::put('/{id}', [TourGuideController::class, 'update'])->name('tourguides.update');
        Route::delete('/{id}', [TourGuideController::class, 'destroy'])->name('tourguides.destroy');
        
    });
    Route::prefix('itineraries')->group(function () {
        Route::get('/index', [ItinerariesController::class,'index'])->name('itineraries.index');


        Route::post('/save', [ItinerariesController::class, 'store'])->name('save.itinerary');
        Route::resource('/', ItinerariesController::class);
        Route::get('/{id}/edit', [ItinerariesController::class, 'edit'])->name('itineraries.edit');
        Route::put('/{id}', [ItinerariesController::class, 'update'])->name('itineraries.update');
        Route::delete('/package/{id}', [ItinerariesController::class, 'destroyByPackage'])->name('itineraries.destroyByPackage');
        // Route::get('/packages/{packageId}/itineraries', [ItinerariesController::class, 'fetchItineraries'])->name('fetch.itineraries');
        Route::post('/store', [ItinerariesController::class, 'store'])->name('save.itinerary');
        Route::delete('/{id}', [ItinerariesController::class, 'destroy'])->name('itineraries.destroy');
    });
    
    Route::prefix('galleries')->group(function () {
        Route::get('/create/{package}', [GalleryController::class, 'create'])->name('galleries.create');
        Route::post('/store', [GalleryController::class, 'store'])->name('galleries.store');
        Route::get('/', [GalleryController::class, 'index'])->name('galleries.index');
        
    });
    Route::prefix('stays')->group(function () {
        Route::get('/', [StaysController::class, 'index'])->name('stays.index');
        Route::get('/create', [StaysController::class, 'create'])->name('stays.create');
        Route::post('/stays', [StaysController::class, 'store'])->name('stays.store');
        Route::get('/{id}/edit', [StaysController::class, 'edit'])->name('stays.edit');
        Route::put('/{id}', [StaysController::class, 'update'])->name('stays.update');
        Route::delete('/{id}', [StaysController::class, 'destroy'])->name('stays.destroy');

    });
    Route::prefix('destinations')->group(function () {
        Route::get('/', [DestinationController::class, 'index'])->name('destinations.index');
        Route::get('/create', [DestinationController::class, 'create'])->name('destinations.create');
        Route::post('/', [DestinationController::class, 'store'])->name('destinations.store');
        Route::get('/{destination}/edit', [DestinationController::class, 'edit'])->name('destinations.edit');
        Route::put('/{destination}', [DestinationController::class, 'update'])->name('destinations.update');
        Route::delete('/{destination}', [DestinationController::class, 'destroy'])->name('destinations.destroy');
        });
    // Blog Routes
    Route::prefix('blogs')->group(function () {
            Route::get('/', [BlogController::class, 'index'])->name('blogs.index'); // Display all blogs
            Route::get('/create', [BlogController::class, 'create'])->name('blogs.create'); // Show form to create a new blog
            Route::post('/store', [BlogController::class, 'store'])->name('blogs.store'); // Store a new blog
            Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('blogs.edit'); // Show form to edit a blog
            Route::put('/{id}', [BlogController::class, 'update'])->name('blogs.update'); // Update an existing blog
            Route::delete('/{id}', [BlogController::class, 'destroy'])->name('blogs.destroy'); // Delete a blog
            });
    //PromotionalPackage
Route::prefix('/promotional-packages')->group(function () {
    Route::get('create', [PromotionalPackageController::class, 'create'])->name('promotional-packages.create');
    Route::post('/store', [PromotionalPackageController::class, 'store'])->name('promotional-packages.store');
    Route::get('/', [PromotionalPackageController::class, 'index'])->name('promotional-packages.index');
    Route::delete('/{id}', [PromotionalPackageController::class, 'destroy'])->name('promotional-packages.destroy');
});

    Route::get('/get-packages', [PromotionalPackageController::class, 'getPackagesByDestination']);
    Route::post('/store-generated-url', [PromotionalPackageController::class, 'storeGeneratedUrl']);
    Route::get('package_stays/{pk_Package_id}', [PackageStayController::class, 'create'])
    ->name('package_stays.create');
    Route::post('/package_stays/{pk_Package_id}/add', [PackageStayController::class, 'store'])
    ->name('package_stays.store');
    Route::match(['get', 'post'], '/inclusions/manage/{packageId}', [InclusionController::class, 'manage'])->name('inclusions.manage');
    Route::delete('/packages/gallery/{id}', [GalleryController::class, 'deleteGalleryImage'])->name('packages.deleteGalleryImage');
    Route::post('/packages/upload-gallery-image', [PackageController::class, 'uploadGalleryImage'])->name('packages.uploadGalleryImage');  

    // Tag and Categories 
    // Categories management
    Route::get('/categories/manage/{pk_Package_id}', [CategoryController::class, 'manage'])->name('categories.manage');
    Route::post('/categories/add', [CategoryController::class, 'add'])->name('categories.add');
    Route::post('/categories/remove', [CategoryController::class, 'remove'])->name('categories.remove');
    Route::get('/package/{pk_Package_id}/back-to-edit', [CategoryController::class, 'backToEdit'])->name('back.to.edit');
    // Tags management
    Route::get('/tags/manage/{pk_Package_id}', [TagController::class, 'manage'])->name('tags.manage');
    Route::post('/tags/add', [TagController::class, 'add'])->name('tags.add');
    Route::post('/tags/remove', [TagController::class, 'remove'])->name('tags.remove');
    Route::get('/{pk_Package_id}', [TagController::class, 'backToEdit'])->name('tags.edit');
    Route::get('/package/{pk_Package_id}/back-to-edit', [TagController::class, 'backToEdit'])->name('back.to.edit');

    // Routes for ClientQuery
    Route::get('client-queries', [ClientQueryController::class, 'index'])->name('client-queries.index');
    Route::get('client-queries/create', [ClientQueryController::class, 'create'])->name('client-queries.create');
    Route::post('client-queries/store', [ClientQueryController::class, 'store'])->name('client-queries.store');
    Route::get('client-queries/{id}', [ClientQueryController::class, 'show'])->name('client-queries.show');
    });

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
Route::get('itineraries/{packageId}', [ItinerariesController::class, 'fetchItineraries']);

use App\Http\Controllers\PromotionalDestinationController;

Route::middleware(['web'])->group(function () {
    // List all promotional destinations
    Route::get('/promotional-destinations', [PromotionalDestinationController::class, 'index'])->name('promotional-destinations.index');

    // Show the form for creating a new promotional destination
    Route::get('/promotional-destinations/create', [PromotionalDestinationController::class, 'create'])->name('promotional-destinations.create');

    // Store a newly created promotional destination
    Route::post('/promotional-destinations', [PromotionalDestinationController::class, 'store'])->name('promotional-destinations.store');

    // Delete a promotional destination
    Route::delete('/promotional-destinations/{id}', [PromotionalDestinationController::class, 'destroy'])->name('promotional-destinations.destroy');
});
