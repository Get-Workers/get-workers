<?php

namespace App\Services\Caches;

use App\Models\Work;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class WorkCacheService
{
    /**
     * @param  Worker  $worker
     * @param  bool  $clear
     *
     * @return Collection|null
     */
    public static function fromWorker(Worker $worker, bool $clear = false): ?Collection
    {
        $key = "worker:{$worker->id}_works";

        if ($clear) {
            Cache::tags(['worker:works'])->forget($key);
            return null;
        }

        return Cache::tags(['worker:works'])->rememberForever($key, function () use (&$worker) {
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
    public static function listPaginate(int $perPage = 20, int $actualPage = 1, array $filters = [], bool $clear = false): ?LengthAwarePaginator
    {
        $filtersJson = json_encode($filters);
        $key = "works:paginate:perPage({$perPage}):page({$actualPage}):withFilters({$filtersJson})";

        if ($clear) {
            Cache::tags(['works:paginate'])->flush();
            return null;
        }

        return Cache::tags(['works:paginate', 'paginate'])->rememberForever($key, function () use (&$perPage, &$actualPage, &$filters) {
            return Work::query()
                ->with([
                    'specialties',
                    'unity',
                    'worker',
                    'specialties',
                ])
                ->filter($filters)
                ->paginate(perPage: $perPage, page: $actualPage);
        });
    }
}
