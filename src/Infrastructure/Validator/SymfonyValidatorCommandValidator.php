<?php

namespace App\Infrastructure\Validator;

use App\Application\Contract\CommandValidatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SymfonyValidatorCommandValidator implements CommandValidatorInterface
{
    /** @var ValidatorInterface */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate($command)
    {
        return $this->validator->validate($command);
    }
}
