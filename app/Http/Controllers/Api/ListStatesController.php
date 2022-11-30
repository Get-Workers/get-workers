<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListStatesController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $states = Country::findOrFail($request->countryId)->states;

        return response()->json(compact('states'));
    }
}
