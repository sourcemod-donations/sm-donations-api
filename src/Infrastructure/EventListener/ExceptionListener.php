<?php

namespace App\Infrastructure\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ExceptionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 10],
        ];
    }

    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $ex = $event->getException();
        $message = 'An error has occurred';
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($ex instanceof AccessDeniedException) {
            $message = 'Access denied';
            $statusCode = $ex->getCode();
        }

        $data = [
            'message' => $message,
        ];
        if (getenv('APP_ENV') === 'dev') {
            $data['exception'] = [
                'message' => $ex->getMessage(),
                'stacktrace' => $ex->getTrace(),
            ];
        }
        $response = new JsonResponse(
            $data,
            $statusCode
        );
        $event->setResponse($response);
    }
}
