<?php

namespace App\Listener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class ExceptionListener
 * @package App\Listener
 */
class ExceptionListener
{
    /**
     * @param GetResponseForExceptionEvent $event
     *
     * @return void
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        if ($exception) {
            $response = JsonResponse::create(['success' => false, 'message' => $exception->getMessage()], $exception->getStatusCode());
            $event->setResponse($response);
        }
    }
}