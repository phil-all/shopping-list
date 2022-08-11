<?php

namespace App\Tests\Func;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RouteTest extends WebTestCase
{
    public function testUsersRessourcesAreNotFound(): void
    {
        $client = static::createClient();

        /** @var User $user */
        $user = static::getContainer()
            ->get(UserRepository::class)
            ->findOneByEmail('user1@example.com');

        $client->loginUser($user);
        $client->catchExceptions(true);
        $response = $client->request(
            'GET',
            '/api/users'
        );

        $this->assertResponseStatusCodeSame(404);
    }
}
