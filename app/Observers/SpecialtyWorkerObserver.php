<?php

namespace App\Observers;

use App\Models\SpecialtyWorker;
use App\Models\Worker;
use App\Services\Caches\SpecialtyWorkerCacheService;

class SpecialtyWorkerObserver
{
    /**
     * Handle the SpecialtyWorker "created" event.
     *
     * @param  \App\Models\SpecialtyWorker  $specialtyWorker
     * @return void
     */
    public function created(SpecialtyWorker $specialtyWorker)
    {
        $this->clearCache($specialtyWorker);
    }

    /**
     * Handle the SpecialtyWorker "updated" event.
     *
     * @param  \App\Models\SpecialtyWorker  $specialtyWorker
     * @return void
     */
    public function updated(SpecialtyWorker $specialtyWorker)
    {
        $this->clearCache($specialtyWorker);
    }

    /**
     * Handle the SpecialtyWorker "deleted" event.
     *
     * @param  \App\Models\SpecialtyWorker  $specialtyWorker
     * @return void
     */
    public function deleted(SpecialtyWorker $specialtyWorker)
    {
        $this->clearCache($specialtyWorker);
    }

    /**
     * Handle the SpecialtyWorker "restored" event.
     *
     * @param  \App\Models\SpecialtyWorker  $specialtyWorker
     * @return void
     */
    public function restored(SpecialtyWorker $specialtyWorker)
    {
        $this->clearCache($specialtyWorker);
    }

    /**
     * Handle the SpecialtyWorker "force deleted" event.
     *
     * @param  \App\Models\SpecialtyWorker  $specialtyWorker
     * @return void
     */
    public function forceDeleted(SpecialtyWorker $specialtyWorker)
    {
        $this->clearCache($specialtyWorker);
    }

    /**
     * @param  SpecialtyWorker  $specialtyWorker
     *
     * @return void
     */
    private function clearCache(SpecialtyWorker $specialtyWorker): void
    {
        SpecialtyWorkerCacheService::FromWorker($specialtyWorker->worker, true);
    }
}
