<?php

namespace App\Http\Controllers\Work\HiredWork;

use App\Http\Controllers\Controller;
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
        $hiredWorks = auth()->user()->contractor->hiredWorks;
        $hiredWorks->load(['work', 'work.worker', 'work.unity', 'work.specialties']);
        return inertia('User/Contractor/HiredWorks/List', compact('hiredWorks'));
    }
}
