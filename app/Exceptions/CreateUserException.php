<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Throwable;

class CreateUserException extends Exception
{
    private const EXCEPTION_MESSAGE = 'Couldn\'t create a user.';

    public function __construct(
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        Throwable|null $previous = null
    ) {
        parent::__construct(self::EXCEPTION_MESSAGE, $code, $previous);
    }
}
