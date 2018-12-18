<?php

namespace App\Infrastructure\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class DtoValidationFailedException extends HttpException
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $violations;

    public function __construct(
        ConstraintViolationListInterface $violations
    ) {
        parent::__construct(400);
        $this->violations = $violations;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
