<?php

namespace App\Infrastructure\ArgumentResolver;

use App\Infrastructure\Contract\RequestDtoInterface;
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
        $dtoInstance = $this->constructDto($request, $argument);

        yield $dtoInstance;
    }

    private function constructDto(Request $request, ArgumentMetadata $argument)
    {
        $attributesBag = $request->attributes;
        $requestBag = $request->request;
        $dtoClass = $argument->getType();
        $constructParams = [];

        $reflection = new \ReflectionClass($dtoClass);
        $constructor = $reflection->getConstructor();
        $parameters = $constructor->getParameters();
        foreach ($parameters as $parameter) {
            // TODO: gracely handle errors caused by typehint non-compliant construct parameter
            $defaultValue = null;
            if ($parameter->isOptional()) {
                $defaultValue = $parameter->getDefaultValue();
            }

            $param = $requestBag->get($parameter->getName(), null)
                ?? $attributesBag->get($parameter->getName(), $defaultValue);

            $constructParams[] = $param;
        }

        return new $dtoClass(...$constructParams);
    }
}
