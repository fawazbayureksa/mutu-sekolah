<?php

namespace App\Exceptions;

use RuntimeException;

class SubmissionNotFoundException extends RuntimeException
{
    public function __construct(string $identifier = '', int $code = 404, ?\Throwable $previous = null)
    {
        $message = $identifier
            ? "Submission '{$identifier}' not found."
            : 'Submission not found.';

        parent::__construct($message, $code, $previous);
    }
}
