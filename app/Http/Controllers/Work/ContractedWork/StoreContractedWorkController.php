<?php

namespace App\Http\Controllers\Work\ContractedWork;

use App\Actions\Work\ContractedWork\StoreContractedWork;
use App\Http\Controllers\Controller;
use App\Http\Requests\Work\ContractedWork\StoreContractedWorkRequest;
use App\Models\Work;
use Illuminate\Http\RedirectResponse;

class StoreContractedWorkController extends Controller
{
    private StoreContractedWork $action;

    public function __construct(StoreContractedWork $action)
    {
        $this->action = $action;
    }
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Work\ContractedWork\StoreContractedWorkRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(StoreContractedWorkRequest $request): RedirectResponse
    {
        $workUuid = $request->validated('work');
        $work = Work::where('uuid', $workUuid)
            ->firstOrFail();

        $this->action->storeContractedWork(auth()->user()->contractor, $work);

        return redirect()->route('works.show', ['workUuid' => $work->uuid])->with('store', true);
    }
}
