<?php

namespace App\Application\Exception;

use Throwable;

class EntityNotFoundException extends \Exception
{
    public function __construct(string $entity, string $id, Throwable $previous = null)
    {
        $message = "Entity $entity with id $id could not be found.";
        parent::__construct($message, 0, $previous);
    }
}
