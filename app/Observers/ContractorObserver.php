<?php

namespace App\Observers;

use App\Models\Contractor;
use App\Services\Caches\ContractorCacheService;

class ContractorObserver
{
    /**
     * Handle the Contractor "created" event.
     *
     * @param  \App\Models\Contractor  $contractor
     * @return void
     */
    public function created(Contractor $contractor)
    {
        $this->clearCache($contractor);
    }

    /**
     * Handle the Contractor "updated" event.
     *
     * @param  \App\Models\Contractor  $contractor
     * @return void
     */
    public function updated(Contractor $contractor)
    {
        $this->clearCache($contractor);
    }

    /**
     * Handle the Contractor "deleted" event.
     *
     * @param  \App\Models\Contractor  $contractor
     * @return void
     */
    public function deleted(Contractor $contractor)
    {
        $this->clearCache($contractor);
    }

    /**
     * Handle the Contractor "restored" event.
     *
     * @param  \App\Models\Contractor  $contractor
     * @return void
     */
    public function restored(Contractor $contractor)
    {
        $this->clearCache($contractor);
    }

    /**
     * Handle the Contractor "force deleted" event.
     *
     * @param  \App\Models\Contractor  $contractor
     * @return void
     */
    public function forceDeleted(Contractor $contractor)
    {
        $this->clearCache($contractor);
    }

    /**
     * @param  Contractor  $contractor
     *
     * @return void
     */
    private function clearCache(Contractor $contractor): void
    {
        ContractorCacheService::ContractorProfile($contractor->user, true);
    }
}
