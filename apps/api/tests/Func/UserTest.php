<?php

namespace App\Tests\Func;

use App\Tests\Func\AbstractApiTest;

class UserTest extends AbstractApiTest
{
    public function testLoginWithValidCredentials(): void
    {
        $response = $this->getLoginResponse();

        $this->assertResponseIsSuccessful();
        $this->assertMatchesJsonSchema([
            "token" => "string",
        ]);
    }

    public function testLoginWithInvalidCredentials(): void
    {
        $response = $this->getLoginResponse([
            'username' => 'fake credentials',
            'password' => 'fake pass',
        ]);

        $this->assertJsonContains(['message' => 'Invalid credentials.']);
        $this->assertResponseStatusCodeSame(401);
    }

    public function testUsersRessourcesAreNotFound(): void
    {
        $response = $this->createAnonymousClient()->request(
            'GET',
            '/api/users'
        );
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJsonContains(['message' => 'Ressource not found']);
        $this->assertResponseStatusCodeSame(404);

        $response = $this->createClientWithCredentials()->request(
            'GET',
            '/api/users'
        );
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJsonContains(['message' => 'Ressource not found']);
        $this->assertResponseStatusCodeSame(404);
    }
}
