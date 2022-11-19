<?php

namespace App\Actions\User\Profile;

use App\Models\User;

class UpdatePhoneNumberAction
{
    public function update(User $user, string $phoneNumber): bool
    {
        $user->phone_number = $phoneNumber;
        return $user->save();
    }
}
