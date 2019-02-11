<?php

namespace App\Application\Service;

use App\Application\Contract\CommandValidatorInterface;
use App\Infrastructure\Exception\DtoValidationFailedException;

class AbstractService
{
    /** @var CommandValidatorInterface */
    private $commandValidator;

    /**
     * @internal
     * @required
     */
    public function setCommandValidator(CommandValidatorInterface $validator)
    {
        $this->commandValidator = $validator;
    }

    /**
     * @throws DtoValidationFailedException
     */
    protected function validCommandOrThrow($command): void
    {
        $errors = $this->commandValidator->validate($command);
        if (\count($errors) !== 0) {
            throw new DtoValidationFailedException($errors);
        }
    }
}
