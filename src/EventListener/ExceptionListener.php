<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();
        $message = sprintf(
                    'Erreur : %s',
                    $exception->getMessage()
                    );

        // Customize your response object to display the exception details
        $response = new JsonResponse($message);

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode($exception->getCode());
        }

        // sends the modified response object to the event
        $event->setResponse($response);
    }
}