<?php

namespace App\Http\Controllers\User\Profile\Worker\MyWork;

use App\Http\Controllers\Controller;
use App\Services\Caches\SpecialtyCacheService;
use App\Services\Caches\UnityCacheService;
use App\Services\Caches\WorkCacheService;
use Illuminate\Http\Request;
use Inertia\Response;

class ShowMyWorksController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function __invoke(Request $request): Response
    {
        $works = WorkCacheService::fromWorker(auth()->user()->worker);
        $works->load('specialties', 'unity');

        $unities = UnityCacheService::all();
        $specialties = SpecialtyCacheService::all();

        return inertia('User/Profile/Worker/MyWorks/Show', compact('works', 'unities', 'specialties'));
    }
}
