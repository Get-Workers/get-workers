<?php

namespace App\Http\Controllers\User\Profile\Worker\HiredWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Worker\HiredWork\DestroyHiredWorkRequest;
use App\Models\HiredWork;
use App\Services\Caches\HiredWorkCacheService;
use Illuminate\Database\Eloquent\Builder;
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
        $worker = auth()->user()->worker;
        $hiredWorkUuid = $request->validated('hiredWork');
        $hiredWork = HiredWork::whereUuid($hiredWorkUuid)
            ->with([
                'work' => fn ($query) => $query->withTrashed(),
                'work.worker'
            ]);
        if (is_null($hiredWork)) {
            abort(Response::HTTP_NOT_FOUND);
        }
        $hiredWork->delete();

        HiredWorkCacheService::findUuid($hiredWorkUuid, clear: true);
        HiredWorkCacheService::fromContractor($hiredWork->contractor, clear:true);
        HiredWorkCacheService::fromWorker($worker, clear:true);

        return redirect()->route('user.profile.worker.hired-works.list')->with('destroy', true);
    }
}
