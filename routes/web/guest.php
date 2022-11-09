<?php

use App\Http\Controllers\Auth\{RegisterController, UserRegisterController};
use App\Http\Controllers\Guest\LandingpageController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', LandingpageController::class)->name('landingpage');

    Route::prefix('/register')->name('register')->group(function () {
        Route::get('', RegisterController::class);
        Route::post('', UserRegisterController::class);
    });
});
