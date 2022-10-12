<?php

namespace App\Http\Controllers\User\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Work;
use Illuminate\Http\Request;
use Inertia\Response;

class ShowWorksController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function __invoke(Request $request): Response
    {
        $works = Work::with([
                'specialties',
                'unity',
                'worker',
                'specialties',
        ])
            ->get();

        return inertia('User/Contractor/Works/Show', compact('works'));
    }
}
