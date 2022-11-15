<?php

namespace App\Actions\User\Profile;

use App\Models\User;

class UpdateCpfAction
{
    public function update(User $user, string $cpf): bool
    {
        $user->cpf = $cpf;
        return $user->save();
    }
}
