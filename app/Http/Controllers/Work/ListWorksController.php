<?php

namespace App\Http\Controllers\Work;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Services\Caches\SpecialtyCacheService;
use App\Services\Caches\WorkCacheService;
use Illuminate\Http\Request;
use Inertia\Response;

class ListWorksController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function __invoke(Request $request): Response
    {
        $page = $request->get('page', 1);
        $filters = $request->all(['search', 'stars', 'specialties', 'city']);
        $filters['moreHires'] = true;
        if (! empty($filters['specialties'])) {
            $filters['specialties'] = explode(',', $filters['specialties']);
        }

        $specialties = SpecialtyCacheService::all();
        $works = WorkCacheService::listPaginate(
            actualPage: $page,
            filters: $filters,
            with: [
                'specialties',
                'unity',
                'worker',
            ]
        );

        $search = $request->get('search', '');
        $stars = (int) $request->get('stars', 0);
        $selectedSpecialties = $specialties
            ->whereIn('id', $filters['specialties'])
            ->values();
        $cityId = (int) $request->get('city');
        $city = City::with('state.country')->find($cityId);

        return inertia('User/Works/List', compact(
            'works',
            'specialties',
            'search',
            'stars',
            'selectedSpecialties',
            'cityId',
            'city'
        ));
    }
}
