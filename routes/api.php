<?php

use App\Http\Controllers\Api\ListCitiesController;
use App\Http\Controllers\Api\ListCountriesController;
use App\Http\Controllers\Api\ListStatesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/countries', ListCountriesController::class)->name('.countries.list');
Route::get('/countries/{countryId}/states', ListStatesController::class)->name('.states.list');
Route::get('/states/{stateId}/cities', ListCitiesController::class)->name('.cities.list');
