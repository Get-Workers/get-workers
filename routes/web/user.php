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
    StoreHiredWorksController
};
use App\Http\Controllers\User\Profile\Worker\Appointments\ShowAppointmentsController;
use App\Http\Controllers\User\Profile\Worker\MyWork\{
    DestroyMyWorksController,
    ShowMyWorksController,
    StoreMyWorksController
};
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::prefix('/user')->name('user')->group(function () {
        Route::prefix('/profile')->name('.profile')->group(function () {
            Route::prefix('/worker')->name('.worker')->middleware('worker-profile')->group(function () {
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
                Route::get('{hiredWorkUuid}', ShowHiredWorksController::class)->name('.show');
                Route::post('', StoreHiredWorksController::class)->name('.store');
                Route::delete('', DestroyHiredWorksController::class)->name('.destroy');
            });
        });
    });

    Route::prefix('/works')->name('works')->group(function () {
        Route::get('', ListWorksController::class)->name('.list');
        Route::get('{workUuid}', ShowWorksController::class)->name('.show');
    });
});
