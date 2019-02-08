<?php

namespace App\Application\Exception\Auth;

use Throwable;

class InvalidAuthTokenException extends \Exception
{
    public function __construct(string $message = 'Invalid authentication token', Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
