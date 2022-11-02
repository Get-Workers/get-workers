<?php

namespace App\Observers;

use App\Models\Certification;
use App\Services\Caches\CertificationCacheService;

class CertificationObserver
{
    /**
     * Handle the Certification "created" event.
     *
     * @param  \App\Models\Certification  $certification
     * @return void
     */
    public function created(Certification $certification)
    {
        $this->clearCache($certification);
    }

    /**
     * Handle the Certification "updated" event.
     *
     * @param  \App\Models\Certification  $certification
     * @return void
     */
    public function updated(Certification $certification)
    {
        $this->clearCache($certification);
    }

    /**
     * Handle the Certification "deleted" event.
     *
     * @param  \App\Models\Certification  $certification
     * @return void
     */
    public function deleted(Certification $certification)
    {
        $this->clearCache($certification);
    }

    /**
     * Handle the Certification "restored" event.
     *
     * @param  \App\Models\Certification  $certification
     * @return void
     */
    public function restored(Certification $certification)
    {
        $this->clearCache($certification);
    }

    /**
     * Handle the Certification "force deleted" event.
     *
     * @param  \App\Models\Certification  $certification
     * @return void
     */
    public function forceDeleted(Certification $certification)
    {
        $this->clearCache($certification);
    }

    /**
     * @param  Certification  $certification
     *
     * @return void
     */
    private function clearCache(Certification $certification): void
    {
        CertificationCacheService::fromWorker($certification->worker, true);
    }
}
