<?php

namespace App\Http\Controllers\User\Profile\Worker\Specialties;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Profile\Worker\DestroySpecialtyRequest;
use \Illuminate\Http\RedirectResponse;

class DestroySpecialtiesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\User\Profile\Worker\StoreSpecialtyRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(DestroySpecialtyRequest $request): RedirectResponse
    {
        $worker = auth()->user()->worker;

        $worker->specialties()
            ->whereKey($request->validated('specialtyId'))
            ->firstOrFail()
            ->pivot
            ->delete();

        return redirect()->route('user.profile.worker.specialties.show')->with('destroy', true);
    }
}
