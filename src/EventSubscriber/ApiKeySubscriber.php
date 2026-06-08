<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiKeySubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly string $auditApiKey) 
    {

    }
    
    public function onKernelRequest(RequestEvent $event): void
    {

        $request = $event->getRequest();

        if (!str_starts_with($request->getPathInfo(), '/api/audit-events')) {

            return;

        }

        $providedApiKey = $request->headers->get('X-API-Key');

        if ($providedApiKey !== $this->auditApiKey) {

            $event->setResponse(new JsonResponse([

                'error' => 'Invalid API key',

            ], 401));

        }

    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
