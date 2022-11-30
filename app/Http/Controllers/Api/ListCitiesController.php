<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListCitiesController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $cities = State::findOrFail($request->stateId)->cities;

        return response()->json(compact('cities'));
    }
}
