<?php

namespace App\Services\Caches;

use App\Models\User;
use App\Models\Worker;
use Illuminate\Support\Facades\Cache;

class WorkerCacheService
{
    /**
     * @param  User  $user
     * @param  bool  $clear
     *
     * @return Worker|null
     */
    public static function WorkerProfile(User $user, bool $clear = false): ?Worker
    {
        $key = "user:{$user->id}_worker_profile";

        if ($clear) {
            Cache::forget($key);
            return null;
        }

        return Cache::rememberForever($key, function () use (&$user) {
            return $user->worker;
        });
    }
}
