<?php

namespace App\Http\Controllers\User\Worker\HiredWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Worker\HiredWork\DoneHiredWorkRequest;
use App\Services\Caches\HiredWorkCacheService;
use Illuminate\Http\RedirectResponse;

class DoneHiredWorksController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  DoneHiredWorkRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(DoneHiredWorkRequest $request): RedirectResponse
    {
        $hiredWork = HiredWorkCacheService::findUuid($request->validated('hiredWork'));
        $hiredWork->done_at = now();
        $hiredWork->save();

        HiredWorkCacheService::findUuid(clearTag: true);
        HiredWorkCacheService::fromWorker(clearTag: true);

        return redirect()->route('user.worker.hired-works.show', ['hiredWorkUuid' => $hiredWork->uuid]);
    }
}
