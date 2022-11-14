<?php

namespace App\Http\Controllers\User\Profile\Worker\Profile;

use App\Actions\Worker\Profile\UpdateCnpjAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Worker\UpdateWorkerCnpjRequest;
use Illuminate\Http\RedirectResponse;

class UpdateWorkerCnpjController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  UpdateWorkerCnpjRequest  $request
     * @return RedirectResponse
     */
    public function __invoke(UpdateWorkerCnpjRequest $request, UpdateCnpjAction $action): RedirectResponse
    {
        $worker = auth()->user()->worker;
        $cnpj = $request->validated('cnpj');

        $action->update($worker, $cnpj);

        return redirect()->route('user.profile.worker.profile.show');
    }
}
