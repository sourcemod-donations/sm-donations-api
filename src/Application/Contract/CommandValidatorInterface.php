<?php

namespace App\Application\Contract;

interface CommandValidatorInterface
{
    public function validate($command);
}
