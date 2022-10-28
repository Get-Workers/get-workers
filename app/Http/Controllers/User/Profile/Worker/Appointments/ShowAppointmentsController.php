<?php

namespace App\Http\Controllers\User\Profile\Worker\Appointments;

use App\Http\Controllers\Controller;
use App\Services\Caches\HiredWorkCacheService;
use Illuminate\Http\Request;
use Inertia\Response;

class ShowAppointmentsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function __invoke(Request $request): Response
    {
        $hiredWorks = HiredWorkCacheService::fromWorker(
            worker: auth()->user()->worker,
            with: 'work.worker.user',
            filters: ['scheduled_to']
        ) ?? [];
        return inertia('User/Profile/Worker/Appointments/Show', compact('hiredWorks'));
    }
}
