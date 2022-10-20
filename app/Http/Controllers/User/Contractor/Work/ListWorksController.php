<?php

namespace App\Http\Controllers\User\Contractor\Work;

use App\Http\Controllers\Controller;
use App\Models\Work;
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
        $works = Work::with([
                'specialties',
                'unity',
                'worker',
                'specialties',
        ])
            ->get();

        return inertia('User/Works/List', compact('works'));
    }
}
