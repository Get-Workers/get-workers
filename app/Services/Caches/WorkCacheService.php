<?php

namespace App\Services\Caches;

use App\Models\Work;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class WorkCacheService
{
    public static function clearAll(): void
    {
        self::fromWorker(clearTag: true);
        self::listPaginate(clear: true);

        HiredWorkCacheService::clearAll();
    }

    /**
     * @param  Worker  $worker
     * @param  bool  $clear
     *
     * @return Collection|null
     */
    public static function fromWorker(?Worker $worker = null, bool $clear = false, bool $clearTag = false): ?Collection
    {
        if ($clearTag) {
            Cache::tags(['worker:works'])->flush();
            return null;
        }

        $key = "worker:{$worker->id}_works";

        if ($clear) {
            Cache::tags(['worker:works'])->forget($key);
            return null;
        }

        return Cache::tags(['worker:works'])->remember($key, now()->addHour(), function () use (&$worker) {
            return $worker->works;
        });
    }

    /**
     * @param  int  $perPage
     * @param  int  $actualPage
     * @param  array  $filters
     * @param  boolean  $clear
     * @return LengthAwarePaginator
     */
    public static function listPaginate(int $perPage = 20, int $actualPage = 1, array $filters = [], array|string $with = '', bool $clear = false): ?LengthAwarePaginator
    {
        $filtersJson = json_encode($filters);
        $withJson = json_encode($with);
        $key = "works:paginate:perPage({$perPage}):page({$actualPage}):withFilters({$filtersJson}):with({$withJson})";

        if ($clear) {
            Cache::tags(['works:paginate', 'paginate'])->flush();
            return null;
        }

        return Cache::tags(['works:paginate', 'paginate'])->remember($key, now()->addHour(), function () use (&$perPage, &$actualPage, &$filters, &$with) {
            $query = Work::query();

            if (! empty($with)) {
                $query->with($with);
            }

            return $query->filter($filters)->paginate(perPage: $perPage, page: $actualPage);
        });
    }
}
