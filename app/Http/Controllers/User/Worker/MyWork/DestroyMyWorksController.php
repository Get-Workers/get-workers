<?php

namespace App\Http\Controllers\User\Worker\MyWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Worker\DestroyMyWorkRequest;
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
            ->firstOrFail()
            ->delete();

        return redirect()->route('user.worker.my-works')->with('destroy', $workDeleted);
    }
}
