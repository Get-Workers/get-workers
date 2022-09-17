<?php

namespace App\Http\Controllers\User\Profile\Worker\Certifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Response;

class ShowCertificationsController extends Controller
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

        $storeStatus = session()->get('store', false);
        $deleteStatus = session()->get('destroy', false);
        return inertia('User/Profile/Worker/Certifications/Show', compact('certifications', 'storeStatus', 'deleteStatus'));
    }
}
