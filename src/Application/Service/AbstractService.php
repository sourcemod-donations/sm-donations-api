<?php

namespace App\Application\Service;

use App\Infrastructure\Exception\DtoValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AbstractService
{
    /** @var ValidatorInterface */
    private $commandValidator;

    /**
     * @internal
     * @required
     */
    public function setCommandValidator(ValidatorInterface $validator)
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
