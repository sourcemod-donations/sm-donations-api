<?php

namespace App\Application\Command\User;

class CreateUserCommand
{
    /**
     * @var int
     */
    public $steamId;

    public function __construct(
        int $steamId
    ) {
        $this->steamId = $steamId;
    }
}
