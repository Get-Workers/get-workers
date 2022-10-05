<?php

namespace App\Observers;

use App\Models\Work;
use App\Services\Caches\WorkCacheService;

class WorkObserver
{
    /**
     * Handle the Work "created" event.
     *
     * @param  \App\Models\Work  $work
     * @return void
     */
    public function created(Work $work)
    {
        $this->clearCache($work);
    }

    /**
     * Handle the Work "updated" event.
     *
     * @param  \App\Models\Work  $work
     * @return void
     */
    public function updated(Work $work)
    {
        $this->clearCache($work);
    }

    /**
     * Handle the Work "deleted" event.
     *
     * @param  \App\Models\Work  $work
     * @return void
     */
    public function deleted(Work $work)
    {
        $this->clearCache($work);
    }

    /**
     * Handle the Work "restored" event.
     *
     * @param  \App\Models\Work  $work
     * @return void
     */
    public function restored(Work $work)
    {
        $this->clearCache($work);
    }

    /**
     * Handle the Work "force deleted" event.
     *
     * @param  \App\Models\Work  $work
     * @return void
     */
    public function forceDeleted(Work $work)
    {
        $this->clearCache($work);
    }

    /**
     * @param  Work  $work
     *
     * @return void
     */
    private function clearCache(Work $work): void
    {
        WorkCacheService::FromWorker($work->worker, true);
    }
}
