<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ApiWeddingVenueController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
   


Route::middleware('auth:sanctum')->group(function () {

    //wedding venues
    Route::get('/my-venues', [ApiWeddingVenueController::class, 'myVenues']);
    Route::post('/venues', [ApiWeddingVenueController::class, 'store']);
  // Feedback route for wedding venues
  Route::post('/venues/{weddingVenue}/feedback', [ApiWeddingVenueController::class, 'storeFeedback']);    //logout
    Route::post('logout', [ApiUserController::class, "logout"]);
     Route::post('/chats', [ChatController::class, 'store']);
    Route::get('/chats/{venueId}', [ChatController::class, 'venueChats']);
    
});
//wedding venues
Route::get('/venues', [ApiWeddingVenueController::class, 'index']);
Route::get('/venues/{venue}', [ApiWeddingVenueController::class, 'show']);

Route::post('login', [ApiUserController::class, "login"]);
Route::post('register', [ApiUserController::class, "register"]);
