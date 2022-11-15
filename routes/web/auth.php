<?php

use App\Http\Controllers\User\Profile\PrivacyPolicyController;
use App\Http\Controllers\User\Profile\TermsOfServiceController;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Jetstream;

if (Jetstream::hasTermsAndPrivacyPolicyFeature()) {
    Route::get('/terms-of-service', [TermsOfServiceController::class, 'show'])->name('terms.show');
    Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('policy.show');
}
