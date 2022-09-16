<?php

namespace App\Http\Controllers\User\Profile\Worker\Certifications;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Profile\Worker\StoreCertificationRequest;
use \Illuminate\Http\RedirectResponse;

class StoreCertificationsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\User\Profile\Worker\StoreSpecialtyRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(StoreCertificationRequest $request): RedirectResponse
    {
        auth()->user()->worker->certifications()->create($request->validated());
        return redirect()->route('user.profile.worker.certifications.show')->with('store', true);
    }
}
