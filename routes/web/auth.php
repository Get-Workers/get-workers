<?php

// use App\Http\Controllers\User\Profile\ApiTokenController;
use App\Http\Controllers\User\Profile\CurrentUserController;
use App\Http\Controllers\User\Profile\OtherBrowserSessionsController;
use App\Http\Controllers\User\Profile\PrivacyPolicyController;
use App\Http\Controllers\User\Profile\ProfilePhotoController;
use App\Http\Controllers\User\Profile\TermsOfServiceController;
use App\Http\Controllers\User\Profile\UserProfileController;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Jetstream;

if (Jetstream::hasTermsAndPrivacyPolicyFeature()) {
    Route::get('/terms-of-service', [TermsOfServiceController::class, 'show'])->name('terms.show');
    Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('policy.show');
}

$authMiddleware = config('jetstream.guard')
        ? 'auth:'.config('jetstream.guard')
        : 'auth';

$authSessionMiddleware = config('jetstream.auth_session', false)
        ? config('jetstream.auth_session')
        : null;

Route::group(['middleware' => array_values(array_filter([$authMiddleware, $authSessionMiddleware]))], function () {
    // User & Profile...
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
});
