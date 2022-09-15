<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;

class UserRegisterController extends Controller
{
    /** @var CreateNewUser */
    private $createNewUserAction;

    /**
     * @param  CreateNewUser  $createNewUserAction
     */
    public function __construct(CreateNewUser $createNewUserAction)
    {
        $this->createNewUserAction = $createNewUserAction;
    }
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\UserRegisterRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(UserRegisterRequest $request): RedirectResponse
    {
        $user = $this->createNewUserAction->create($request->validated());
        auth()->login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}
