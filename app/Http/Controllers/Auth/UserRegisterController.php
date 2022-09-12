<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use Inertia\Response;

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
     * @param  UserRegisterRequest  $request
     * @return Response
     */
    public function __invoke(UserRegisterRequest $request): Response
    {
        $user = $this->createNewUserAction->create($request->validated());
        auth()->login($user);
        return inertia('Dashboard');
    }
}
