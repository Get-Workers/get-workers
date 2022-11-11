<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
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
        $works = WorkCacheService::listPaginate(
            perPage: 21,
            actualPage: $request->input('page', 1),
            filters: ['moreHires'],
            with: ['unity', 'worker.user']
        );

        return inertia('Landingpage', compact('works'));
    }
}
