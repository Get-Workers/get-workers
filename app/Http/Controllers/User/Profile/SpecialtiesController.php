<?php

namespace App\Http\Controllers\User\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Response;

class SpecialtiesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function __invoke(Request $request): Response
    {
        $specialties = auth()->user()->worker->specialties ?? [];
        return inertia('User/Profile/Specialties/Show', compact('specialties'));
    }
}
