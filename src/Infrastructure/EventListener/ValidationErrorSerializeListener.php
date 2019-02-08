<?php

namespace App\Infrastructure\EventListener;

use App\Infrastructure\Exception\DtoValidationFailedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationErrorSerializeListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 20],
        ];
    }

    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();
        if (!$exception instanceof DtoValidationFailedException) {
            return;
        }

        $message = [
            'message' => 'Input validation failed',
            'errors' => $this->serialize($exception->getViolations()),
        ];
        $response = new JsonResponse(
            $message,
            Response::HTTP_BAD_REQUEST
        );
        $event->setResponse($response);
    }

    /**
     * @param ConstraintViolationListInterface $violations
     * @return string[]
     */
    private function serialize(ConstraintViolationListInterface $violations): array
    {
        $errors = [];
        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            $errors[] = [
                'field' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }

        return $errors;
    }
}
