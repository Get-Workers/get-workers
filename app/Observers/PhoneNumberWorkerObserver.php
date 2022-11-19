<?php

namespace App\Observers;

use App\Models\PhoneNumberWorker;
use App\Services\Caches\HiredWorkCacheService;
use App\Services\Caches\WorkCacheService;
use App\Services\Caches\WorkerCacheService;

class PhoneNumberWorkerObserver
{
    /**
     * Handle the PhoneNumberWorker "created" event.
     *
     * @param  \App\Models\PhoneNumberWorker  $phoneNumberWorker
     * @return void
     */
    public function created(PhoneNumberWorker $phoneNumberWorker)
    {
        $this->clearCache($phoneNumberWorker);
    }

    /**
     * Handle the PhoneNumberWorker "updated" event.
     *
     * @param  \App\Models\PhoneNumberWorker  $phoneNumberWorker
     * @return void
     */
    public function updated(PhoneNumberWorker $phoneNumberWorker)
    {
        $this->clearCache($phoneNumberWorker);
    }

    /**
     * Handle the PhoneNumberWorker "deleted" event.
     *
     * @param  \App\Models\PhoneNumberWorker  $phoneNumberWorker
     * @return void
     */
    public function deleted(PhoneNumberWorker $phoneNumberWorker)
    {
        $this->clearCache($phoneNumberWorker);
    }

    /**
     * Handle the PhoneNumberWorker "restored" event.
     *
     * @param  \App\Models\PhoneNumberWorker  $phoneNumberWorker
     * @return void
     */
    public function restored(PhoneNumberWorker $phoneNumberWorker)
    {
        $this->clearCache($phoneNumberWorker);
    }

    /**
     * Handle the PhoneNumberWorker "force deleted" event.
     *
     * @param  \App\Models\PhoneNumberWorker  $phoneNumberWorker
     * @return void
     */
    public function forceDeleted(PhoneNumberWorker $phoneNumberWorker)
    {
        $this->clearCache($phoneNumberWorker);
    }

    /**
     * @param  PhoneNumberWorker  $phoneNumberWorker
     * @return void
     */
    private function clearCache(PhoneNumberWorker $phoneNumberWorker): void
    {
        WorkerCacheService::workerProfile($phoneNumberWorker->worker->user, true);
        WorkCacheService::clearAll();
        HiredWorkCacheService::clearAll();
    }
}
