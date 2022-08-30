<?php

namespace App\Actions\Fortify;

use App\Exceptions\CreateUserException;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return User
     *
     * @throws CreateUserException
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return $this->createNewUser($input);
    }

    /**
     * @param  array  $attributes
     * @return User
     */
    private function createNewUser(array $attributes): User
    {
        $user = null;
        DB::transaction(function () use (&$user, &$attributes) {
            $user = User::create([
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'password' => Hash::make($attributes['password']),
            ]);

            $this->createWorkerFromUser($user);
        });

        if (is_null($user)) {
            throw new CreateUserException();
        }

        return $user;
    }

    /**
     * @param  User  $user
     * @return Worker
     */
    private function createWorkerFromUser(User $user): Worker
    {
        return $user->worker()->create();
    }
}
