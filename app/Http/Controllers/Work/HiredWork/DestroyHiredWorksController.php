<?php

namespace App\Http\Controllers\Work\HiredWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\Work\HiredWork\DestroyHiredWorkRequest;
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

        return redirect()->route('hired-works.list')->with('destroy', true);
    }
}
