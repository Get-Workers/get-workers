<?php

namespace App\Actions\User\Contractor\HiredWork;

use App\Exceptions\HiredWorkAlreadyHasContractorReview;
use App\Models\Contractor;
use App\Models\HiredWork;
use App\Models\Review;

class StoreReviewAction
{
    public function store(Contractor $contractor, string $hiredWorkUuid, array $reviewData): Review
    {
        /**
         * @var HiredWork
         */
        $hiredWork = $contractor->hiredWorks()
            ->with('reviews')
            ->whereUuid($hiredWorkUuid)
            ->firstOrFail();

        if (! is_null($hiredWork->contractor_review)) {
            throw new HiredWorkAlreadyHasContractorReview();
        }

        $review = $hiredWork->reviews()->create([
            'contractor_id' => $contractor->id,
            ...$reviewData,
        ]);

        return $review;
    }
}
