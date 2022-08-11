<?php

namespace App\EventSubscriber;

use App\Entity\Product;
use App\Service\Responder\Responder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RequestSubscriber implements EventSubscriberInterface
{
    private Responder $responder;

    private RequestStack $requestStack;

    private ManagerRegistry $managerRegistry;

    private TokenStorageInterface $tokenStorage;

    private JWTTokenManagerInterface $jwtManager;

    public function __construct(
        Responder $responder,
        RequestStack $requestStack,
        ManagerRegistry $managerRegistry,
        TokenStorageInterface $tokenStorage,
        JWTTokenManagerInterface $jwtManager
    ) {
        $this->responder        = $responder;
        $this->jwtManager       = $jwtManager;
        $this->tokenStorage     = $tokenStorage;
        $this->requestStack     = $requestStack;
        $this->managerRegistry  = $managerRegistry;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $message    = null;
        $status     = null;
        $jwtToken   = $this->tokenStorage->getToken();
        $route      = $this->requestStack->getMainRequest()->attributes->get('_route');
        $requestUri = $event->getRequest()->server->get('REQUEST_URI');

        if (null != $jwtToken && $route === 'api_products_get_item') {
            $productId = (int)preg_replace('/\/api\/products\//', '', $event->getRequest()->getRequestUri());

            /** @var Product $product */
            $product = $this->managerRegistry->getRepository(Product::class)->find($productId);

            $userId       = $this->jwtManager->decode($this->tokenStorage->getToken())['id'];
            $ownerId      = $product->getOwner()->getId();

            if ($userId !== $ownerId) {
                $message = 'Requested ressource is not your own.';
                $status  = 401;
            }
        }

        if ($status !== null) {
            $event->setResponse($this->responder->getErrorJsonResponse($message, $status));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }
}
