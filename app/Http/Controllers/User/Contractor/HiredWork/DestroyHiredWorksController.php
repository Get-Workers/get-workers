<?php

namespace App\Http\Controllers\User\Contractor\HiredWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Contractor\HiredWork\DestroyHiredWorkRequest;
use App\Models\HiredWork;
use App\Services\Caches\HiredWorkCacheService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class DestroyHiredWorksController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Work\HiredWork\StoreHiredWorkRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(DestroyHiredWorkRequest $request): RedirectResponse
    {
        $contractor = auth()->user()->contractor;
        $hiredWorkUuid = $request->validated('hiredWork');
        $hiredWork = HiredWork::whereUuid($hiredWorkUuid)
            ->with([
                'work' => fn ($query) => $query->withTrashed(),
                'work.worker'
            ])
            ->first();
        $hiredWork->delete();

        HiredWorkCacheService::findUuid($hiredWorkUuid, clear: true);
        HiredWorkCacheService::fromContractor(clearTag: true);
        HiredWorkCacheService::fromWorker(clearTag: true);

        return redirect()->route('user.contractor.hired-works.list')->with('destroy', true);
    }
}
