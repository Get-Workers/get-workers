<?php

namespace App\Services\Caches;

use App\Models\Worker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class SpecialtyWorkerCacheService
{
    /**
     * @param  Worker  $worker
     * @param  bool  $clear
     *
     * @return Collection|null
     */
    public static function fromWorker(Worker $worker, bool $clear = false): ?Collection
    {
        $key = "worker:{$worker->id}_specialties";

        if ($clear) {
            Cache::forget($key);
            return null;
        }

        return Cache::remember($key, now()->addHour(), function () use (&$worker) {
            return $worker->specialties;
        });
    }
}
