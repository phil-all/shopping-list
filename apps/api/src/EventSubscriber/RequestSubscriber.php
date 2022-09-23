<?php

namespace App\EventSubscriber;

use Generator;
use App\Entity\Product;
use App\Entity\ItemList;
use App\Entity\ShoppingList;
use App\Service\Responder\Responder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * RequestSubscriber class
 * Used to correct some wrong 404 Http code responses due to
 * doctrine CurentUserExtension filter on user ressources.
 * @package App\EventSubscriber
 */
class RequestSubscriber implements EventSubscriberInterface
{
    private Responder $responder;

    private RequestStack $requestStack;

    private TokenStorageInterface $tokenStorage;

    public function __construct(
        Responder $responder,
        RequestStack $requestStack,
        TokenStorageInterface $tokenStorage
    ) {
        $this->responder        = $responder;
        $this->tokenStorage     = $tokenStorage;
        $this->requestStack     = $requestStack;
    }

    /**
     * Provide http methods
     *
     * @return Generator
     */
    public function httpMethodProvider(): Generator
    {
        yield Request::METHOD_GET;
        yield Request::METHOD_PUT;
        yield Request::METHOD_DELETE;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $options = [
            'token' => $this->tokenStorage->getToken(),
            'route' => $this->requestStack->getMainRequest()->attributes->get('_route'),
            'event' => $event,
        ];

        /** @var string httpMethod */
        foreach ($this->httpMethodProvider() as $httpMethod) {
            $this->responder->setUnauthorizedItemOperationsResponse(ShoppingList::class, $httpMethod, $options);
            $this->responder->setUnauthorizedItemOperationsResponse(ItemList::class, $httpMethod, $options);
            $this->responder->setUnauthorizedItemOperationsResponse(Product::class, $httpMethod, $options);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }
}
