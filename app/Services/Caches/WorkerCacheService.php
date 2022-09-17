<?php

namespace App\Services\Caches;

use App\Models\User;
use App\Models\Worker;
use Illuminate\Support\Facades\Cache;

class WorkerCacheService
{
    /**
     * @param  User  $user
     * @return Worker|null
     */
    public static function WorkerProfile(User $user): Worker|null
    {
        return Cache::rememberForever("user:{$user->id}_worker_profile", function () use ($user) {
            return $user->worker;
        });
    }
}
