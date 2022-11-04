<?php

namespace App\Http\Controllers\User\Profile\Worker\HiredWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Worker\HiredWork\InitiateHiredWorkRequest;
use App\Services\Caches\HiredWorkCacheService;
use Illuminate\Http\RedirectResponse;

class InitiateHiredWorksController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  InitiateHiredWorkRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(InitiateHiredWorkRequest $request): RedirectResponse
    {
        $hiredWork = HiredWorkCacheService::findUuid($request->validated('hiredWork'));
        $hiredWork->initiated_at = now();
        $hiredWork->save();

        HiredWorkCacheService::findUuid(clearTag: true);
        HiredWorkCacheService::fromWorker(clearTag: true);

        return redirect()->route('user.profile.worker.hired-works.show', ['hiredWorkUuid' => $hiredWork->uuid]);
    }
}
