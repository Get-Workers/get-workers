<?php

namespace App\Http\Controllers\User\Contractor\HiredWork;

use App\Actions\Work\HiredWork\StoreHiredWork;
use App\Http\Controllers\Controller;
use App\Http\Requests\Work\HiredWork\StoreHiredWorkRequest;
use App\Models\Work;
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
        $workUuid = $request->validated('work');
        $work = Work::where('uuid', $workUuid)
            ->firstOrFail();

        $this->action->storeHiredWork(auth()->user()->contractor, $work);

        return redirect()->route('works.show', ['workUuid' => $work->uuid])->with('store', true);
    }
}
