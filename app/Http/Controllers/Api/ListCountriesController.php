<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\JsonResponse;

class ListCountriesController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $countries = Country::all();

        return response()->json(compact('countries'));
    }
}
