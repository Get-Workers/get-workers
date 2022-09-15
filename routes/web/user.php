<?php

use App\Http\Controllers\User\Profile\Worker\Specialties\{ ShowSpecialtiesController, StoreSpecialtiesController };
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::prefix('/user')->name('user')->group(function () {
        Route::prefix('/profile')->name('.profile')->group(function () {
            Route::prefix('/worker')->name('.worker')->group(function () {
                Route::prefix('/specialties')->name('.specialties')->group(function () {
                    Route::get('', ShowSpecialtiesController::class)->name('.show');
                    Route::post('', StoreSpecialtiesController::class)->name('.store');
                });
            });
        });
    });
});
