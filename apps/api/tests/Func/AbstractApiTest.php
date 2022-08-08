<?php

namespace App\Tests\Func;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Contracts\HttpClient\ResponseInterface;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

abstract class AbstractApiTest extends ApiTestCase
{
    protected ?string $token = null;

    private const HEADERS = [
        'ACCEPT'       => 'application/json',
        'CONTENT_TYPE' => 'application/json'
    ];

    public function setUp(): void
    {
        self::bootKernel();
    }

    /**
     * Create anonymous Client
     *
     * @return Client
     */
    protected function createAnonymousClient(): Client
    {
        return static::createClient([], ['headers' => $this->getHeaders()]);
    }

    /**
     * Create Client with credentials
     *
     * @param string|null $token
     *
     * @return Client
     */
    protected function createClientWithCredentials(?string $token = null): Client
    {
        $token = $token ?: $this->getToken();

        return static::createClient([], ['headers' => ['authorization' => 'Bearer ' . $token]]);
    }

    /**
     * Get an access token
     *
     * @param array $body
     *
     * @return string
     */
    protected function getToken(array $body = []): string
    {
        if (null !== $this->token) {
            return $this->token;
        }

        $response = $this->getLoginResponse($body);
        $data = json_decode($response->getContent());
        $this->token = $data->token;

        return $data->token;
    }

    /**
     * Get a login response
     *
     * @param array $body
     *
     * @return ResponseInterface
     */
    protected function getLoginResponse(array $body = []): ResponseInterface
    {
        return static::createClient()->request(
            'POST',
            '/api/login_check',
            [
                'json' => $body ?: [
                    'username' => 'user1@example.com',
                    'password' => 'pass1234',
                ],
                'headers' => $this->getheaders(),
            ],
        );
    }

    /**
     * Get headers constant
     *
     * @return array
     */
    protected function getHeaders(): array
    {
        return self::HEADERS;
    }

    /**
     * Access an entity repository
     *
     * @param class-string $class (e.g. User::class)
     *
     * @return EntityRepository
     */
    protected function getRepository(string $class): EntityRepository
    {
        return $this->getEntityManager()->getRepository($class);
    }

    /**
     * Access the entity manager
     *
     * @return EntityManager
     */
    private function getEntityManager(): EntityManager
    {
        /** @var EntityManager $manager */
        $manager = self::bootKernel()->getContainer()->get('doctrine')->getManager();

        return $manager;
    }
}
