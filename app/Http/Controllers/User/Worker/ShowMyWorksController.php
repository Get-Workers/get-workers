<?php

namespace App\Http\Controllers\User\Worker;

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
        $works = WorkCacheService::FromWorker(auth()->user()->worker);
        $works->load('specialties', 'unity');

        $unities = UnityCacheService::all();
        $specialties = SpecialtyCacheService::all();
        $storeStatus = session()->get('store', false);
        $deleteStatus = session()->get('destroy', false);
        return inertia('User/Worker/MyWorks/Show', compact('works', 'unities', 'specialties', 'storeStatus', 'deleteStatus'));
    }
}
