<?php

use App\Http\Controllers\api\ApiLikeController;
use App\Http\Controllers\api\ApiPlaceController;
use App\Http\Controllers\api\ApiRatingController;
use App\Http\Controllers\API\ScrapingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/place/all', [ApiPlaceController::class, 'all']);
// Route::get('/place/yamaguchi', [ApiPlaceController::class, 'yamaguchi']);
// Route::get('/place/hagi', [ApiPlaceController::class, 'hagi']);
// Route::get('/place/syuunan', [ApiPlaceController::class, 'syuunan']);
// Route::get('/place/shimonoseki', [ApiPlaceController::class, 'shimonoseki']);
// Route::get('/place/houhu', [ApiPlaceController::class, 'houhu']);
// Route::get('/place/ubeonoda', [ApiPlaceController::class, 'ubeonoda']);
// Route::get('/place/iwakunihikari', [ApiPlaceController::class, 'iwakunihikari']);

Route::get('/place/rating', [ApiRatingController::class, 'rating']);

Route::post('/like/{post}', [ApiLikeController::class, 'store']);
Route::delete('/like/delete/{post}', [ApiLikeController::class, 'destroy']);

// Route::get('/scraping/amazon', [ScrapingController::class, 'amazon_scrape']);
// Route::get('/scraping/yahoo', [ScrapingController::class, 'yahoo_scrape']);
