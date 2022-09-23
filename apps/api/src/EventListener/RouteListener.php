<?php

namespace App\EventListener;

use App\Service\Responder\Responder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * RouteListener
 * @package App\EventListener
 */
class RouteListener implements EventSubscriberInterface
{
    private Responder $responder;

    public function __construct(
        Responder $responder
    ) {
        $this->responder     = $responder;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $message    = null;
        $status     = null;

        if (str_contains($event->getRequest()->server->get('REQUEST_URI'), '/api/users')) {
            $message = 'Unauthorized to access users';
            $status  = 401;
        }

        if ($status !== null) {
            $event->setResponse($this->responder->getErrorJsonResponse($message, $status));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 50]],
        ];
    }
}
