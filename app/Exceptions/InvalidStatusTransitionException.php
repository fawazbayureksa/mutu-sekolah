<?php

namespace App\Exceptions;

use RuntimeException;

class InvalidStatusTransitionException extends RuntimeException
{
    public function __construct(string $from, string $to, int $code = 422, ?\Throwable $previous = null)
    {
        $message = "Cannot transition submission status from '{$from}' to '{$to}'.";

        parent::__construct($message, $code, $previous);
    }
}
