<?php

namespace App\Http\Controllers\User\Contractor\HiredWork;

use App\Actions\Work\HiredWork\StoreHiredWork;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Contractor\HiredWork\StoreHiredWorkRequest;
use App\Models\Work;
use App\Services\Caches\HiredWorkCacheService;
use Illuminate\Http\RedirectResponse;

class StoreHiredWorksController extends Controller
{
    private StoreHiredWork $action;

    public function __construct(StoreHiredWork $action)
    {
        $this->action = $action;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Work\HiredWork\StoreHiredWorkRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(StoreHiredWorkRequest $request): RedirectResponse
    {
        $contractor = auth()->user()->contractor;
        $workUuid = $request->validated(['work']);
        $work = Work::where('uuid', $workUuid)
            ->first();

        $hiredWork = $this->action->storeHiredWork(
            $contractor,
            $work,
            $request->safe(['scheduled_to'])
        );

        HiredWorkCacheService::fromContractor(clearTag: true);
        HiredWorkCacheService::fromWorker(clearTag: true);

        return redirect()->route('user.contractor.hired-works.show', ['hiredWorkUuid' => $hiredWork->uuid])->with('store', true);
    }
}
