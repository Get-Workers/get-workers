<?php

namespace App\Http\Controllers\User\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Response;

class ShowCertificationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function __invoke(Request $request): Response
    {
        $certifications = auth()->user()->worker->certifications ?? [];
        return inertia('User/Profile/Certification/Show', compact('certifications'));
    }
}
