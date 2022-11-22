<?php

namespace App\Http\Controllers\User\Contractor\HiredWork;

use App\Actions\User\Contractor\HiredWork\StoreReviewAction;
use App\Exceptions\HiredWorkAlreadyHasContractorReview;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Contractor\HiredWork\StoreReviewRequest;
use App\Services\Caches\HiredWorkCacheService;
use Exception;
use Illuminate\Http\RedirectResponse;

class StoreReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  string  $hiredWorkUuid
     * @param  \App\Http\Requests\Work\HiredWork\StoreReviewRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(
        string $hiredWorkUuid,
        StoreReviewRequest $request,
        StoreReviewAction $action
    ): RedirectResponse {
        $user = auth()->user();
        $contractor = $user->contractor;

        $redirect = redirect()
            ->route('user.contractor.hired-works.show',
                ['hiredWorkUuid' => $hiredWorkUuid]
            );

        try {
            $action->store(
                $contractor,
                $hiredWorkUuid,
                $request->validated()
            );

            HiredWorkCacheService::clearAll();

            return $redirect;
        } catch (HiredWorkAlreadyHasContractorReview $e) {
            return $redirect
                ->withErrors(['hiredWork' => $e->getMessage()]);
        } catch (Exception $e) {
            return $redirect
                ->withErrors(['unexpected' => __('exception.unexpected')]);
        }
    }
}
