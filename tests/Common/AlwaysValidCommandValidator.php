<?php

namespace App\Tests\Common;

use App\Application\Contract\CommandValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class AlwaysValidCommandValidator implements CommandValidatorInterface
{
    public function validate($command)
    {
        return new ConstraintViolationList();
    }
}
