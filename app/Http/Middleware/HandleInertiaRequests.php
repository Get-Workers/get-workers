<?php

namespace App\Http\Middleware;

use App\Models\Contractor;
use App\Models\User;
use App\Models\Worker;
use App\Services\Caches\ContractorCacheService;
use App\Services\Caches\WorkerCacheService;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $user = auth()->user();
        $user->load(['city.state.country']);

        return array_merge(parent::share($request), [
            'contractor' => $this->getContractorProfile($user),
            'worker' => $this->getWorkerProfile($user),
        ]);
    }

    /**
     * @param  User|null  $user
     * @return Contractor|null
     */
    private function getContractorProfile(?User $user): Contractor|null
    {
        if (is_null($user)) {
            return null;
        }
        return ContractorCacheService::contractorProfile($user);
    }

    /**
     * @param  User|null  $user
     * @return Worker|null
     */
    private function getWorkerProfile(?User $user): Worker|null
    {
        if (is_null($user)) {
            return null;
        }
        return WorkerCacheService::workerProfile($user);
    }
}
