<?php

namespace App\Application\Exception\Auth;

use Throwable;

class AuthFailedException extends \Exception
{
    public function __construct(string $message = 'Authentication failed', Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
