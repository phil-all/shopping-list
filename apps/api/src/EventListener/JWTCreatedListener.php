<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

/**
 * Add custom datas in JWT payload
 */
class JWTCreatedListener
{
    private RequestStack $requestStack;

    private ManagerRegistry $managerRegistry;

    public function __construct(RequestStack $requestStack, ManagerRegistry $managerRegistry)
    {
        $this->requestStack    = $requestStack;
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * Add user id in payload on JWT creation
     */
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();

        if (array_key_exists('username', $event->getData())) {
            $username = $event->getData()['username'];

            /** @var User $user */
            $user = $this->managerRegistry->getRepository(User::class)->findOneBy(['email' => $username]);

            $payload       = $event->getData();
            $payload['id'] = $user->getId();

            $event->setData($payload);
        }
    }
}
