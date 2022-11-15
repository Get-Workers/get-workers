<?php

namespace App\Http\Controllers\User\Profile;

use App\Actions\User\Profile\UpdateCpfAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Profile\UpdateCpfRequest;
use Illuminate\Http\RedirectResponse;

class UpdateCpfController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  UpdateCpfRequest  $request
     * @return RedirectResponse
     */
    public function __invoke(UpdateCpfRequest $request, UpdateCpfAction $action): RedirectResponse
    {
        $user = auth()->user();
        $cpf = $request->validated('cpf');

        $action->update($user, $cpf);

        return redirect()->route('profile.show');
    }
}
