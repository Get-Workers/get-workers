<?php

use App\Http\Controllers\Auth\{RegisterController, UserRegisterController};
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return inertia('Landingpage');
    })->name('landingpage');

    Route::prefix('/register')->name('register')->group(function () {
        Route::get('', RegisterController::class);
        Route::post('', UserRegisterController::class);
    });
});
