<?php

namespace App\Http\Controllers\User\Contractor\HiredWork;

use App\Http\Controllers\Controller;
use App\Services\Caches\HiredWorkCacheService;
use Inertia\Response;

class ListHiredWorksController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Inertia\Response
     */
    public function __invoke(): Response
    {
        $hiredWorks = HiredWorkCacheService::fromContractor(
            auth()->user()->contractor,
            [
                'work' => fn ($query) => $query->withTrashed(),
                'work.worker',
                'work.unity',
                'work.specialties'
            ]
        );

        $deleteStatus = session()->get('destroy', false);
        return inertia('User/Contractor/HiredWorks/List', compact('hiredWorks', 'deleteStatus'));
    }
}
