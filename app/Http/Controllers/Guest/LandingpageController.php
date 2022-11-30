<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Services\Caches\SpecialtyCacheService;
use App\Services\Caches\WorkCacheService;
use Illuminate\Http\Request;
use Inertia\Response;

class LandingpageController extends Controller
{
    /**
     * @param  Request  $request
     * @return Response
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
            perPage: 21,
            actualPage: $page,
            filters: $filters,
            with: ['unity', 'worker.user']
        );

        $search = $request->get('search', '');
        $stars = (int) $request->get('stars', 0);
        $selectedSpecialties = $specialties
            ->whereIn('id', $filters['specialties'])
            ->values();
        $cityId = (int) $request->get('city');
        $city = City::with('state.country')->find($cityId);

        return inertia('Landingpage', compact(
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
