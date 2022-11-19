<?php

namespace App\Http\Controllers\User\Profile\Worker\Profile;

use App\Actions\Worker\Profile\UpdatePhoneNumbersAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Worker\UpdateWorkerPhoneNumbersRequest;
use Illuminate\Http\RedirectResponse;

class UpdateWorkerPhoneNumbersController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  UpdateWorkerPhoneNumbersRequest  $request
     * @return RedirectResponse
     */
    public function __invoke(UpdateWorkerPhoneNumbersRequest $request, UpdatePhoneNumbersAction $action): RedirectResponse
    {
        $worker = auth()->user()->worker;
        $phoneNumbers = $request->validated('phoneNumbers');

        $action->update($worker, $phoneNumbers);

        return redirect()->route('user.profile.worker.profile.show');
    }
}
