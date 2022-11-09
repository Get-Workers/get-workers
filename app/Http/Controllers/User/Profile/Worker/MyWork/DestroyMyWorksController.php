<?php

namespace App\Http\Controllers\User\Profile\Worker\MyWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Worker\DestroyMyWorkRequest;
use App\Services\Caches\WorkCacheService;
use Illuminate\Http\RedirectResponse;

class DestroyMyWorksController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\User\Worker\DestroyMyWorkRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(DestroyMyWorkRequest $request): RedirectResponse
    {
        $workDeleted = auth()->user()->worker
            ->works()
            ->where('uuid', $request->validated('work'))
            ->first()
            ->delete();

            WorkCacheService::listPaginate(clear: true);

        return redirect()->route('user.profile.worker.my-works.show')->with('destroy', $workDeleted);
    }
}
