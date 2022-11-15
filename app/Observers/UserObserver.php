<?php

namespace App\Observers;

use App\Models\User;
use App\Services\Caches\ContractorCacheService;
use App\Services\Caches\WorkerCacheService;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user): void
    {
        $this->clearCache($user);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user): void
    {
        $this->clearCache($user);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user): void
    {
        $this->clearCache($user);
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user): void
    {
        $this->clearCache($user);
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user): void
    {
        $this->clearCache($user);
    }

    /**
     * @param  User  $user
     * @return void
     */
    private function clearCache(User $user): void
    {
        WorkerCacheService::workerProfile($user, true);
        ContractorCacheService::contractorProfile($user, true);
    }
}
