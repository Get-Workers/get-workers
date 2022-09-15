<?php

namespace App\Http\Controllers\User\Profile;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Jetstream\Jetstream;

class TermsOfServiceController extends Controller
{
    /**
     * Show the terms of service for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function show(Request $request): Response
    {
        $termsFile = Jetstream::localizedMarkdownPath('terms.md');

        return inertia('TermsOfService', [
            'terms' => Str::markdown(file_get_contents($termsFile)),
        ]);
    }
}
