<?php

namespace App\Listener;

use HttpInvalidParamException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class ExceptionListener
 * @package App\Listener
 */
class ExceptionListener
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * ExceptionListener constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     *
     * @return void
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        if ($exception instanceof HttpExceptionInterface) {
            $response = JsonResponse::create(['success' => false, 'message' => $this->translator->trans($exception->getMessage())], $exception->getStatusCode(), $exception->getHeaders());
            $event->setResponse($response);
        }
        if ($exception instanceof \Exception) {
            $response = JsonResponse::create(['success' => false, 'message' => $this->translator->trans($exception->getMessage())], 500);
            $event->setResponse($response);
        }
        if ($exception instanceof UnauthorizedHttpException) {
            $message = $exception->getMessage() ? $exception->getMessage() : 'Пользователь не найден';
            $response = JsonResponse::create(['success' => false, 'message' => $this->translator->trans($message)], 401);
            $event->setResponse($response);
        }
        if ($exception instanceof NotFoundHttpException) {
            $response = JsonResponse::create(['success' => false, 'message' => $this->translator->trans($exception->getMessage())], $exception->getStatusCode());
            $event->setResponse($response);
        }
        if ($exception instanceof HttpInvalidParamException) {
            $response = JsonResponse::create(['success' => false, 'message' => $this->translator->trans($exception->getMessage())], 422);
            $event->setResponse($response);
        }
    }
}