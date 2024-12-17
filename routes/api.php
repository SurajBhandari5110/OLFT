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
