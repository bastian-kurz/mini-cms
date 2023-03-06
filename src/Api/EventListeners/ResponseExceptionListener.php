<?php

declare(strict_types=1);

namespace App\Api\EventListeners;

use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Throwable;

class ResponseExceptionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['onKernelException', -1]
            ]
        ];
    }

    public function onKernelException(ExceptionEvent $event): ExceptionEvent
    {
        $exception = $event->getThrowable();

        $statusCode = $this->getStatusCode($exception);

        $response = new JsonResponse();
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_INVALID_UTF8_SUBSTITUTE);
        $response->setData(
            [
                'errors' => [
                    'code' => (string)$exception->getCode(),
                    'status' => (string)$statusCode,
                    'title' => Response::$statusTexts[$statusCode] ?? 'unknown status',
                    'detail' => $exception->getMessage()
                ]
            ]
        );
        $response->setStatusCode($statusCode);
        $event->setResponse($response);

        return $event;
    }

    private function getStatusCode(Throwable $throwable): int
    {
        if ($throwable instanceof OAuthServerException) {
            if ($throwable->getErrorType() === 'invalid_grant') {
                return Response::HTTP_UNAUTHORIZED;
            }
            return $throwable->getHttpStatusCode();
        }

        if ($throwable instanceof HttpException) {
            return $throwable->getStatusCode();
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
