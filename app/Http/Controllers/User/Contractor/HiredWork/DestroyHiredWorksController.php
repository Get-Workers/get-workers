<?php

namespace App\Http\Controllers\User\Contractor\HiredWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Contractor\HiredWork\DestroyHiredWorkRequest;
use App\Services\Caches\HiredWorkCacheService;
use Illuminate\Http\RedirectResponse;

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
        $hiredWorkUuid = $request->validated('hiredWork');

        auth()->user()->contractor
            ->hiredWorks()
            ->whereUuid($hiredWorkUuid)
            ->first()
            ->delete();

        HiredWorkCacheService::findUuid($hiredWorkUuid, clear: true);

        return redirect()->route('user.contractor.hired-works.list')->with('destroy', true);
    }
}
