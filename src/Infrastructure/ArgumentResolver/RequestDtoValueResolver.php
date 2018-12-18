<?php

namespace App\Infrastructure\ArgumentResolver;

use App\Infrastructure\Contract\RequestDtoInterface;
use App\Infrastructure\Exception\DtoValidationFailedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDtoValueResolver implements ArgumentValueResolverInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @inheritdoc
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return is_subclass_of($argument->getType(), RequestDtoInterface::class);
    }

    /**
     * @inheritdoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $dtoClass = $argument->getType();
        $dtoInstance = new $dtoClass($request);
        $errors = $this->validator->validate($dtoInstance);
        if(\count($errors) !== 0) {
            throw new DtoValidationFailedException($errors);
        }

        yield $dtoInstance;
    }
}
