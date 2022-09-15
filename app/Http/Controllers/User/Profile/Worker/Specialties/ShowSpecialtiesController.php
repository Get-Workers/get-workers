<?php

namespace App\Http\Controllers\User\Profile\Worker\Specialties;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Inertia\Response;

class ShowSpecialtiesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function __invoke(Request $request): Response
    {
        $userSpecialties = auth()->user()->worker->specialties ?? [];
        $userSpecialtiesIds = $userSpecialties->pluck('id');
        $specialties = Specialty::whereKeyNot($userSpecialtiesIds)->get();

        $storeStatus = session()->get('store', false);
        $deleteStatus = session()->get('destroy', false);
        return inertia('User/Profile/Worker/Specialties/Show', compact('specialties', 'userSpecialties', 'storeStatus', 'deleteStatus'));
    }
}
