<?php

namespace App\Services\Caches;

use App\Models\User;
use App\Models\Worker;
use Illuminate\Support\Facades\Cache;

class WorkerCacheService
{
    /**
     * @return void
     */
    public static function clearAll(): void
    {
        self::workerProfile(clearTag: true);
    }

    /**
     * @param  User  $user
     * @param  bool  $clear
     *
     * @return Worker|null
     */
    public static function workerProfile(?User $user = null, bool $clear = false, bool $clearTag = false): ?Worker
    {
        if ($clearTag) {
            Cache::tags(['user:workerProfile'])->flush();
            return null;
        }

        $key = "user:{$user->id}_worker_profile";

        if ($clear) {
            Cache::tags(['user:workerProfile'])->forget($key);
            return null;
        }

        return Cache::tags(['user:workerProfile'])->remember($key, now()->addHour(), function () use (&$user) {
            return $user->worker;
        });
    }
}
