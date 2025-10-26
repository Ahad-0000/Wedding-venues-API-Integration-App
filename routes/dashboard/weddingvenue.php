<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeddingVenueController;
use App\Http\Middleware\Isadmin;



Route::middleware(['auth',Isadmin::class])->group(function(){
    Route::prefix('dashboard')->name('dashboard.')->group(function(){
Route::resource('weddingvenues',WeddingVenueController::class);
Route::post('venues/{venue}/approve', [WeddingVenueController::class, 'approve'])->name('venues.approve');
    });
});


