<?php

namespace App\Actions\Auth;

use App\Exceptions\CreateUserException;
use App\Models\Contractor;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
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
            $this->createContractorFromUser($user);
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

    /**
     * @param  User  $user
     * @return Contractor
     */
    private function createContractorFromUser(User $user): Contractor
    {
        return $user->contractor()->create();
    }
}
