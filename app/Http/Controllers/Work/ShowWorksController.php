<?php

namespace App\Http\Controllers\Work;

use App\Http\Controllers\Controller;
use App\Models\Work;
use Illuminate\Http\Request;
use Inertia\Response;

class ShowWorksController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function __invoke(string $workUuid, Request $request): Response
    {
        $work = Work::with([
                'specialties',
                'unity',
                'worker',
                'worker.user',
                'specialties',
        ])
            ->whereUuid($workUuid)
            ->firstOrFail();

        return inertia('User/Works/Show', compact('work'));
    }
}
