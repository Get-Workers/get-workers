<?php

namespace App\Services\Caches;

use App\Models\Worker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class WorkCacheService
{
    /**
     * @param  Worker  $worker
     * @param  bool  $clear
     *
     * @return Collection|null
     */
    public static function FromWorker(Worker $worker, bool $clear = false): ?Collection
    {
        $key = "worker:{$worker->id}_works";

        if ($clear) {
            Cache::forget($key);
            return null;
        }

        return Cache::rememberForever($key, function () use (&$worker) {
            return $worker->certifications;
        });
    }
}
