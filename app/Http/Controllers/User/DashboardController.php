<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Caches\WorkCacheService;
use Illuminate\Http\Request;
use Inertia\Response;

class DashboardController extends Controller
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
            filters: ['moreHires' => true],
            with: ['unity', 'worker.user']
        );

        return inertia('Dashboard', compact('works'));
    }
}
