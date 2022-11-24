<?php

namespace App\Observers;

use App\Models\HiredWork;
use App\Services\Caches\HiredWorkCacheService;

class HiredWorkObserver
{
    /**
     * Handle the HiredWork "created" event.
     *
     * @param  HiredWork  $hiredWork
     * @return void
     */
    public function created(HiredWork $hiredWork): void
    {
        $this->clearCache($hiredWork);
    }

    /**
     * Handle the HiredWork "updated" event.
     *
     * @param  HiredWork  $hiredWork
     * @return void
     */
    public function updated(HiredWork $hiredWork): void
    {
        $this->clearCache($hiredWork);
    }

    /**
     * Handle the HiredWork "deleted" event.
     *
     * @param  HiredWork  $hiredWork
     * @return void
     */
    public function deleted(HiredWork $hiredWork): void
    {
        $this->clearCache($hiredWork);
    }

    /**
     * Handle the HiredWork "restored" event.
     *
     * @param  HiredWork  $hiredWork
     * @return void
     */
    public function restored(HiredWork $hiredWork): void
    {
        $this->clearCache($hiredWork);
    }

    /**
     * Handle the HiredWork "force deleted" event.
     *
     * @param  HiredWork  $hiredWork
     * @return void
     */
    public function forceDeleted(HiredWork $hiredWork): void
    {
        $this->clearCache($hiredWork);
    }

    /**
     * @param  HiredWork  $hiredWork
     * @return void
     */
    private function clearCache(HiredWork $hiredWork): void
    {
        HiredWorkCacheService::clearAll();
    }
}
