<?php

namespace App\Http\Controllers\User\Contractor\HiredWork;

use App\Actions\User\Contractor\HiredWork\StoreReviewAction;
use App\Exceptions\HiredWorkAlreadyHasContractorReview;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Contractor\HiredWork\StoreReviewActionRequest;
use App\Services\Caches\HiredWorkCacheService;
use Exception;
use Illuminate\Http\RedirectResponse;

class StoreReviewActionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  string  $hiredWorkUuid
     * @param  \App\Http\Requests\Work\HiredWork\StoreReviewActionRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(
        string $hiredWorkUuid,
        StoreReviewActionRequest $request,
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
