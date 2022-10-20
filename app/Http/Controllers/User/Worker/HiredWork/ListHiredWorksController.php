<?php

namespace App\Http\Controllers\User\Worker\HiredWork;

use App\Http\Controllers\Controller;
use App\Models\HiredWork;
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

        $works = auth()->user()->worker->works()->whereHas('hiredWorks')->get();
        $hiredWorks = HiredWork::whereIn('work_id', $works->modelKeys())
            ->with(['work', 'work.worker', 'work.unity', 'work.specialties'])
            ->latest()
            ->get();
        return inertia('User/Worker/HiredWorks/List', compact('hiredWorks'));
    }
}
