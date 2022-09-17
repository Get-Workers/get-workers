<?php

namespace App\Services\Caches;

use App\Models\Contractor;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ContractorCacheService
{
    /**
     * @param  User  $user
     * @return Contractor|null
     */
    public static function ContractorProfile(User $user): Contractor|null
    {
        return Cache::rememberForever("user:{$user->id}_contractor_profile", function () use ($user) {
            return $user->contractor;
        });
    }
}
