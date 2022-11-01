<?php

namespace App\Http\Controllers\User\Worker\HiredWork;

use App\Http\Controllers\Controller;
use App\Services\Caches\HiredWorkCacheService;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Response;

class ShowHiredWorksController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Inertia\Response
     */
    public function __invoke(string $hiredWorkUuid): Response
    {
        $hiredWork = HiredWorkCacheService::findUuid($hiredWorkUuid, [
            'work',
            'work.unity',
            'contractor',
            'contractor.user',
        ]);
        if (is_null($hiredWork)) {
            abort(HttpResponse::HTTP_NOT_FOUND);
        }

        return inertia('User/Worker/HiredWorks/Show', compact('hiredWork'));
    }
}
