<?php

namespace App\Exceptions;

use RuntimeException;

class TokenExpiredException extends RuntimeException
{
    public function __construct(string $message = 'The update token has expired or is invalid.', int $code = 410, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
