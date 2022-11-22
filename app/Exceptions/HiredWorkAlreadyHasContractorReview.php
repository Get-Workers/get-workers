<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Throwable;

class HiredWorkAlreadyHasContractorReview extends Exception
{
    public function __construct(
        string $message = 'exception.hired_work_already_has_a_contractor_review',
        int $code = Response::HTTP_UNPROCESSABLE_ENTITY,
        Throwable|null $previous = null
    ) {
        parent::__construct(
            __($message),
            $code,
            $previous
        );
    }
}
