<?php

namespace App\Http\Controllers\User\Profile;

use App\Actions\User\Profile\UpdatePhoneNumberAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Profile\UpdatePhoneNumberRequest;
use Illuminate\Http\RedirectResponse;

class UpdatePhoneNumberController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  UpdatePhoneNumberRequest  $request
     * @return RedirectResponse
     */
    public function __invoke(UpdatePhoneNumberRequest $request, UpdatePhoneNumberAction $action): RedirectResponse
    {
        $user = auth()->user();
        $phoneNumber = $request->validated('phoneNumber');

        $action->update($user, $phoneNumber);

        return redirect()->route('profile.show');
    }
}
