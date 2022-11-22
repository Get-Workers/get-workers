<?php

namespace App\Http\Controllers\User\Contractor\HiredWork;

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
            'work' => fn ($query) => $query->withTrashed(),
            'work.unity',
            'work.worker',
            'work.worker.user',
            'work.worker.phoneNumbers',
            'contractor',
            'reviews',
        ]);
        if (is_null($hiredWork)) {
            abort(HttpResponse::HTTP_NOT_FOUND);
        }

        return inertia('User/Contractor/HiredWorks/Show', compact('hiredWork'));
    }
}
