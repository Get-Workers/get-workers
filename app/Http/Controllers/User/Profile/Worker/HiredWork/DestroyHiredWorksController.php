<?php

namespace App\Http\Controllers\User\Profile\Worker\HiredWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Worker\HiredWork\DestroyHiredWorkRequest;
use App\Models\HiredWork;
use App\Services\Caches\HiredWorkCacheService;
use Illuminate\Database\Eloquent\Builder;
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
        $worker = auth()->user()->worker;
        $hiredWorkUuid = $request->validated('hiredWork');


        HiredWork::whereUuid($hiredWorkUuid)
            ->whereHas('work.worker', function (Builder $query) use (&$worker) {
                $query->whereId($worker->id);
            })
            ->delete();

        HiredWorkCacheService::fromWorker(clearTag: true);

        return redirect()->route('user.profile.worker.hired-works.list')->with('destroy', true);
    }
}
