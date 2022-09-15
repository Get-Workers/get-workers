<?php

namespace App\Http\Controllers\User\Profile\Worker\Specialties;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Profile\Worker\StoreSpecialtyRequest;
use App\Models\Specialty;
use \Illuminate\Http\RedirectResponse;

class StoreSpecialtiesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\User\Profile\Worker\StoreSpecialtyRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(StoreSpecialtyRequest $request): RedirectResponse
    {
        $specialty = Specialty::findOrFail($request->validated('specialtyId'));
        auth()->user()->worker->specialties()->save($specialty);

        return redirect()->route('user.profile.worker.specialties.show')->with('store', true);
    }
}
