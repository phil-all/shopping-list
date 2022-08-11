<?php

namespace App\Tests\Func;

use App\Entity\User;
use App\Entity\Product;
use App\Tests\Func\AbstractApiTest;

class ProductTest extends AbstractApiTest
{
    public function testAnonymousUserCanNotAccessProductsEndPoints(): void
    {
        // products list routes
        $response = $this->createAnonymousClient()->request(
            'GET',
            '/api/products'
        );
        $this->assertJsonContains(['message' => 'JWT Token not found']);
        $this->assertResponseStatusCodeSame(401);

        $response = $this->createAnonymousClient()->request(
            'POST',
            '/api/products'
        );
        $this->assertJsonContains(['message' => 'JWT Token not found']);
        $this->assertResponseStatusCodeSame(401);

        // specific product routes
        $response = $this->createAnonymousClient()->request(
            'GET',
            '/api/products/1'
        );
        $this->assertJsonContains(['message' => 'JWT Token not found']);
        $this->assertResponseStatusCodeSame(401);

        $response = $this->createAnonymousClient()->request(
            'PUT',
            '/api/products/1'
        );
        $this->assertResponseStatusCodeSame(401);

        $response = $this->createAnonymousClient()->request(
            'DELETE',
            '/api/products/1'
        );
        $this->assertResponseStatusCodeSame(401);
    }

    public function testUserGetOnlyOwnProducts(): void
    {
        $email = "user1@example.com";

        /** @var User $owner */
        $owner = $this->getRepository(User::class)->findOneBy(["email" => $email]);

        $userProducts = $this->getRepository(Product::class)->findBy(['owner' => $owner]);

        $client = $this->createClientWithCredentials($this->getToken([
            'username' => $email,
            'password' => 'pass1234',
        ]));

        $response = $client->request(
            'GET',
            '/api/products',
            ['headers' => $this->getHeaders()]
        );

        $countUserProducts  = count($userProducts);
        $countTotalProducts = count(json_decode($response->getContent()));

        $this->assertResponseIsSuccessful();
        $this->assertNotEquals($countUserProducts, $countTotalProducts);
    }

    public function testUserGetsOwnSpecificProduct(): void
    {
        $email = "user1@example.com";

        /** @var User $owner */
        $owner = $this->getRepository(User::class)->findOneBy(["email" => $email]);

        /** @var Product $ownedProduct */
        $ownedProduct = $this->getRepository(Product::class)->findOneBy(['owner' => $owner]);

        $token = $this->getToken([
            'username' => $email,
            'password' => 'pass1234',
        ]);

        $response = $this->createClientWithCredentials($token)->request(
            'GET',
            '/api/products/' . $ownedProduct->getId(),
            ['headers' => $this->getHeaders()]
        );

        $this->assertResponseIsSuccessful();
    }

    public function testUserCreateProduct(): void
    {
        $response = $this->createClientWithCredentials()->request(
            'POST',
            '/api/products',
            [
                'json' => [
                    'name' => 'a new product'
                ],
                'headers' => $this->getHeaders(),
            ]
        );

        $this->assertResponseStatusCodeSame(201);
    }

    public function testUserModifyOwnProduct(): void
    {
        /** @var User $owner */
        $owner = $this->getRepository(User::class)->find(1);

        /** @var Product $ownedProduct */
        $ownedProduct = $this->getRepository(Product::class)->findOneBy(['owner' => $owner]);

        $token = $this->getToken([
            'username' => $owner->getEmail(),
            'password' => 'pass1234',
        ]);

        $response = $this->createClientWithCredentials($token)->request(
            'PUT',
            '/api/products/' . $ownedProduct->getId(),
            [
                'json' => [
                    'name' => 'a new name'
                ],
                'headers' => $this->getHeaders(),
            ]
        );

        $this->assertResponseIsSuccessful();
    }

    public function testUserDeleteOnlyOwnProduct(): void
    {
        /** @var User $owner */
        $owner = $this->getRepository(User::class)->find(1);

        /** @var Product $ownedProduct */
        $ownedProduct = $this->getRepository(Product::class)->findOneBy(['owner' => $owner]);

        $token = $this->getToken([
            'username' => $owner->getEmail(),
            'password' => 'pass1234',
        ]);

        $response = $this->createClientWithCredentials($token)->request(
            'DELETE',
            '/api/products/' . $ownedProduct->getId()
        );

        $this->assertResponseStatusCodeSame(204);
    }
}
