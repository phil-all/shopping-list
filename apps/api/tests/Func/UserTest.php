<?php

namespace App\Tests\Func;

use App\Tests\Func\AbstractApiTest;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class UserTest extends AbstractApiTest
{
    public function testLoginWithValidCredentials(): void
    {
        $response = $this->getLoginResponse();

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
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
}
