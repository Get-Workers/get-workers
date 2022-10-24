<?php

namespace App\Services\Caches;

use App\Models\Contractor;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ContractorCacheService
{
    /**
     * @param  User  $user
     * @param  bool  $clear
     *
     * @return Contractor|null
     */
    public static function contractorProfile(User $user, bool $clear = false): Contractor|null
    {
        $key = "user:{$user->id}_contractor_profile";

        if ($clear) {
            Cache::forget($key);
            return null;
        }

        return Cache::rememberForever($key, function () use (&$user) {
            return $user->contractor;
        });
    }
}
