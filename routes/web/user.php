<?php

use App\Http\Controllers\Work\{
    ListWorksController,
    ShowWorksController
};
use App\Http\Controllers\User\Profile\Worker\Certifications\{
    DestroyCertificationsController,
    ShowCertificationsController,
    StoreCertificationsController
};
use App\Http\Controllers\User\Profile\Worker\Specialties\{
    DestroySpecialtiesController,
    ShowSpecialtiesController,
    StoreSpecialtiesController
};
use App\Http\Controllers\User\Profile\Worker\HiredWork\{
    ListHiredWorksController as WorkerListHiredWorksController,
    DestroyHiredWorksController as WorkerDestroyHiredWorksController,
    DoneHiredWorksController,
    InitiateHiredWorksController,
    ShowHiredWorksController as WorkerShowHiredWorksController
};
use App\Http\Controllers\User\Contractor\HiredWork\{
    DestroyHiredWorksController,
    ListHiredWorksController,
    ShowHiredWorksController,
    StoreHiredWorksController,
    StoreReviewController
};
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\Profile\{
    CurrentUserController,
    OtherBrowserSessionsController,
    ProfilePhotoController,
    UpdateCpfController,
    UpdatePhoneNumberController,
    UserProfileController
};
use App\Http\Controllers\User\Profile\Worker\Appointments\ShowAppointmentsController;
use App\Http\Controllers\User\Profile\Worker\MyWork\{
    DestroyMyWorksController,
    ShowMyWorksController,
    StoreMyWorksController,
    UpdateMyWorksController
};
use App\Http\Controllers\User\Profile\Worker\Profile\{
    ShowWorkerProfileController,
    UpdateWorkerCnpjController,
    UpdateWorkerPhoneNumbersController
};
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Jetstream;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/user/profile', [UserProfileController::class, 'show'])
        ->name('profile.show');

    Route::delete('/user/other-browser-sessions', [OtherBrowserSessionsController::class, 'destroy'])
        ->name('other-browser-sessions.destroy');

    Route::delete('/user/profile-photo', [ProfilePhotoController::class, 'destroy'])
        ->name('current-user-photo.destroy');

    if (Jetstream::hasAccountDeletionFeatures()) {
        Route::delete('/user', [CurrentUserController::class, 'destroy'])
            ->name('current-user.destroy');
    }

    // Route::group(['middleware' => 'verified'], function () {
    //     // API...
    //     if (Jetstream::hasApiFeatures()) {
    //         Route::get('/user/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
    //         Route::post('/user/api-tokens', [ApiTokenController::class, 'store'])->name('api-tokens.store');
    //         Route::put('/user/api-tokens/{token}', [ApiTokenController::class, 'update'])->name('api-tokens.update');
    //         Route::delete('/user/api-tokens/{token}', [ApiTokenController::class, 'destroy'])->name('api-tokens.destroy');
    //     }
    // });

    Route::prefix('/user')->name('user')->group(function () {
        // Profile
        Route::prefix('/profile')->name('.profile')->group(function () {
            Route::put('/cpf', UpdateCpfController::class)->name('.cpf');
            Route::put('/phone-number', UpdatePhoneNumberController::class)->name('.phone-number');

            // Worker
            Route::prefix('/worker')->name('.worker')->middleware('worker-profile')->group(function () {
                Route::prefix('/profile')->name('.profile')->group(function () {
                    Route::get('', ShowWorkerProfileController::class)->name('.show');
                    Route::put('cnpj', UpdateWorkerCnpjController::class)->name('.cnpj');
                    Route::put('phone-numbers', UpdateWorkerPhoneNumbersController::class)->name('.phone-numbers');
                });

                Route::prefix('/specialties')->name('.specialties')->group(function () {
                    Route::get('', ShowSpecialtiesController::class)->name('.show');
                    Route::post('', StoreSpecialtiesController::class)->name('.store');
                    Route::delete('', DestroySpecialtiesController::class)->name('.destroy');
                });

                Route::prefix('/certifications')->name('.certifications')->group(function () {
                    Route::get('', ShowCertificationsController::class)->name('.show');
                    Route::post('', StoreCertificationsController::class)->name('.store');
                    Route::delete('', DestroyCertificationsController::class)->name('.destroy');
                });

                Route::prefix('/my-works')->name('.my-works')->group(function () {
                    Route::get('', ShowMyWorksController::class)->name('.show');
                    Route::post('', StoreMyWorksController::class)->name('.store');
                    Route::put('', UpdateMyWorksController::class)->name('.update');
                    Route::delete('', DestroyMyWorksController::class)->name('.destroy');
                });

                Route::prefix('/hired-works')->name('.hired-works')->group(function () {
                    Route::get('', WorkerListHiredWorksController::class)->name('.list');
                    Route::get('/{hiredWorkUuid}', WorkerShowHiredWorksController::class)->name('.show');
                    Route::delete('', WorkerDestroyHiredWorksController::class)->name('.destroy');
                    Route::post('/initiate', InitiateHiredWorksController::class)->name('.initiate');
                    Route::post('/done', DoneHiredWorksController::class)->name('.done');
                });

                Route::prefix('/appointments')->name('.appointments')->group(function () {
                    Route::get('', ShowAppointmentsController::class)->name('.show');
                });
            });
        });

        Route::prefix('/contractor')->name('.contractor')->middleware('contractor-profile')->group(function () {
            Route::prefix('/hired-works')->name('.hired-works')->group(function () {
                Route::get('', ListHiredWorksController::class)->name('.list');
                Route::get('/{hiredWorkUuid}', ShowHiredWorksController::class)->name('.show');
                Route::post('', StoreHiredWorksController::class)->name('.store');
                Route::delete('', DestroyHiredWorksController::class)->name('.destroy');

                Route::post('/{hiredWorkUuid}/review', StoreReviewController::class)->name('.review.store');
            });
        });
    });

    Route::prefix('/works')->name('works')->group(function () {
        Route::get('', ListWorksController::class)->name('.list');
        Route::get('{workUuid}', ShowWorksController::class)->name('.show');
    });
});
