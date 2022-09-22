<?php

namespace App\Observers;

use App\Models\Worker;
use App\Services\Caches\WorkerCacheService;

class WorkerObserver
{
    /**
     * Handle the Worker "created" event.
     *
     * @param  \App\Models\Worker  $worker
     * @return void
     */
    public function created(Worker $worker)
    {
        $this->clearCache($worker);
    }

    /**
     * Handle the Worker "updated" event.
     *
     * @param  \App\Models\Worker  $worker
     * @return void
     */
    public function updated(Worker $worker)
    {
        $this->clearCache($worker);
    }

    /**
     * Handle the Worker "deleted" event.
     *
     * @param  \App\Models\Worker  $worker
     * @return void
     */
    public function deleted(Worker $worker)
    {
        $this->clearCache($worker);
    }

    /**
     * Handle the Worker "restored" event.
     *
     * @param  \App\Models\Worker  $worker
     * @return void
     */
    public function restored(Worker $worker)
    {
        $this->clearCache($worker);
    }

    /**
     * Handle the Worker "force deleted" event.
     *
     * @param  \App\Models\Worker  $worker
     * @return void
     */
    public function forceDeleted(Worker $worker)
    {
        $this->clearCache($worker);
    }

    /**
     * @param  Worker  $worker
     *
     * @return void
     */
    private function clearCache(Worker $worker): void
    {
        WorkerCacheService::WorkerProfile($worker->user, true);
    }
}
