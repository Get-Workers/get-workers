<?php

namespace App\Services\Caches;

use App\Models\HiredWork;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class HiredWorkCacheService
{
    /**
     * @param  Worker  $worker
     * @param  array|string  $with
     * @param  bool  $clear
     * @param  bool  $clearTag
     *
     * @return Collection|null
     */
    public static function fromWorker(
        Worker $worker,
        array|string $with = '',
        array $filters = [],
        bool $clear = false,
        bool $clearTag = false
    ): ?Collection {
        if ($clearTag) {
            Cache::tags(['worker:works:hired_works'])->flush();
            return null;
        }

        $withJson = json_encode($with);
        $filtersJson = json_encode($filters);
        $key = "worker:{$worker->uuid}:works:hired_works:with({$withJson}):filters({$filtersJson})";

        if ($clear) {
            Cache::tags(['worker:works:hired_works'])->forget($key);
            return null;
        }

        return Cache::tags(['worker:works:hired_works'])->rememberForever($key, function () use (&$worker, &$with, &$filters, &$groupBy) {
            $query = HiredWork::filter($filters);

            if (! empty($with)) {
                $query->with($with);
            }

            $query->whereHas('work.worker', function (Builder $query) use (&$worker) {
                $query->whereWorkerId($worker->id);
            });

            return $query->get();
        });
    }
}
