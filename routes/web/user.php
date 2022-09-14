<?php

use App\Http\Controllers\User\Profile\SpecialtiesController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::prefix('/user')->name('user')->group(function () {
        Route::get('/profile/worker/specialties', SpecialtiesController::class)
            ->name('.profile.worker.specialties.show');
    });
});
