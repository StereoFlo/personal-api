<?php

namespace App\Application\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class HttpRequestListener
 * @package Application\Listeners
 */
class HttpRequestListener
{
    /**
     * @var GetResponseEvent
     */
    private $event;

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $this->event = $event;
        if ($this->hasContent()) {
            $this->setRequest($this->getJsonDecoded());
        }
    }

    /**
     * @return string
     */
    private function getContentType(): string
    {
        return \strtolower($this->event->getRequest()->headers->get('content-type'));
    }

    /**
     * @return bool
     */
    private function hasContent(): bool
    {
        return $this->event->getRequest()->getContent() && (0 === strpos($this->getContentType(), 'application/json'));
    }

    /**
     * @return array
     */
    private function getJsonDecoded(): array
    {
        $data = \json_decode($this->event->getRequest()->getContent(), true);
        if (\json_last_error() !== JSON_ERROR_NONE) {
            throw new BadRequestHttpException();
        }
        return $data;
    }

    /**
     * @param array $data
     *
     * @return HttpRequestListener
     */
    private function setRequest(array $data = []): self
    {
        if (empty($data)) {
            return $this;
        }

        foreach ($data as $k => $v) {
            $this->event->getRequest()->request->set($k, $v);
        }
        return $this;
    }

}