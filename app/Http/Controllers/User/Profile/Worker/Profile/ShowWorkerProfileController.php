<?php

namespace App\Http\Controllers\User\Profile\Worker\Profile;

use App\Http\Controllers\Controller;
use Inertia\Response;

class ShowWorkerProfileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(): Response
    {
        return inertia('User/Profile/Worker/Profile/Show');
    }
}
