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
        $worker = auth()->user()->worker;

        $phoneNumbers = $worker->phoneNumberWorker()
            ->with('phoneNumber')
            ->get();

        return inertia('User/Profile/Worker/Profile/Show', compact('phoneNumbers'));
    }
}
