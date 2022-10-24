<?php

namespace App\Http\Controllers\Work;

use App\Http\Controllers\Controller;
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
        $filters = $request->all(['search']);
        $works = WorkCacheService::listPaginate(actualPage: $page, filters: $filters);
        return inertia('User/Works/List', compact('works'));
    }
}
