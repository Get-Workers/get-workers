<?php

namespace App\Http\Controllers\User\Profile\Worker\Certifications;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Profile\Worker\DestroyCertificationRequest;
use \Illuminate\Http\RedirectResponse;

class DestroyCertificationsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\User\Profile\Worker\DestroyCertificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(DestroyCertificationRequest $request): RedirectResponse
    {
        $certificationDeleted = auth()->user()->worker
            ->certifications()
            ->where('uuid', $request->validated('certification'))
            ->firstOrFail()
            ->delete();

        return redirect()->route('user.profile.worker.certifications.show')->with('destroy', $certificationDeleted);
    }
}
