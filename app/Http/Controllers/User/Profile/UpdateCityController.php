<?php

namespace App\Http\Controllers\User\Profile;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UpdateCityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $cityId = $request->city;

        $city = City::find($cityId);
        if (! empty($city)) {
            $user->city()->associate($city);
        } else {
            $user->city()->dissociate();
        }
        $user->save();

        return redirect()->route('profile.show');
    }
}
